import Quill from 'quill/core';

const Embed = Quill.import('blots/embed');

const OPEN = '{{';
const CODE = /^[A-Za-z0-9_]*$/;
const PLACEHOLDER = /\{\{\s*([A-Za-z0-9_]+)\s*\}\}/g;

const ICON = '<svg viewBox="0 0 18 18"><path class="ql-stroke" fill="none" d="M6 3.5H5.5A1.5 1.5 0 0 0 4 5v2.5A1.5 1.5 0 0 1 2.5 9 1.5 1.5 0 0 1 4 10.5V13a1.5 1.5 0 0 0 1.5 1.5H6M12 3.5h.5A1.5 1.5 0 0 1 14 5v2.5A1.5 1.5 0 0 0 15.5 9 1.5 1.5 0 0 0 14 10.5V13a1.5 1.5 0 0 1-1.5 1.5H12"/></svg>';

export class FieldBlot extends Embed {
  static blotName = 'field';
  static tagName = 'span';
  static className = 'ql-field';

  static create(value) {
    const node = super.create();
    const field = typeof value === 'string' ? value : value.field;
    node.dataset.field = field;
    node.textContent = field;

    return node;
  }

  static value(node) {
    return { field: node.dataset.field };
  }

  html() {
    return OPEN + this.domNode.dataset.field + '}}';
  }
}

export default class Fields {
  constructor(quill, options = {}) {
    this.quill = quill;
    this.fields = (options.fields ?? []).map((field) => (
      typeof field === 'string' ? { field, description: '' } : { description: '', ...field }
    ));
    this.known = new Set(this.fields.map(({ field }) => field));

    this.matches = [];
    this.active = 0;
    this.start = null;

    this.buildList();
    this.buildPicker();

    quill.on('text-change', (delta, old, source) => source === Quill.sources.USER && this.update());
    quill.on('selection-change', (range) => (range && range.length === 0 ? this.update() : this.close()));
    quill.root.addEventListener('blur', () => this.close());

    const bind = (key, handler) => {
      quill.keyboard.addBinding({ key }, (range) => (this.isOpen() ? handler(range) : true));
      quill.keyboard.bindings[key].unshift(quill.keyboard.bindings[key].pop());
    };
    bind('Enter', () => this.choose(this.matches[this.active]));
    bind('Tab', () => this.choose(this.matches[this.active]));
    bind('Escape', () => this.close());
    bind('ArrowDown', () => this.highlight(this.active + 1));
    bind('ArrowUp', () => this.highlight(this.active - 1));
  }

  expand(html) {
    if (!html || this.known.size === 0) {
      return html;
    }

    const template = document.createElement('template');
    template.innerHTML = html;

    const walker = document.createTreeWalker(template.content, NodeFilter.SHOW_TEXT);
    const texts = [];
    while (walker.nextNode()) {
      texts.push(walker.currentNode);
    }

    texts.forEach((text) => {
      const value = text.nodeValue;
      const parts = [];
      let last = 0;

      for (const match of value.matchAll(PLACEHOLDER)) {
        if (!this.known.has(match[1])) {
          continue;
        }
        parts.push(document.createTextNode(value.slice(last, match.index)));
        parts.push(FieldBlot.create(match[1]));
        last = match.index + match[0].length;
      }

      if (parts.length > 0) {
        parts.push(document.createTextNode(value.slice(last)));
        text.replaceWith(...parts);
      }
    });

    return template.innerHTML;
  }

  insert(field, index, length = 0) {
    const quill = this.quill;
    quill.deleteText(index, length, Quill.sources.USER);
    quill.insertEmbed(index, 'field', { field }, Quill.sources.USER);
    const next = quill.getText(index + 1, 1);
    if (/[\p{L}\p{N}]/u.test(next)) {
      quill.insertText(index + 1, ' ', Quill.sources.USER);
    }
    quill.setSelection(index + 1, 0, Quill.sources.USER);
  }

  buildList() {
    this.list = document.createElement('ul');
    this.list.className = 'ql-field-list';
    this.list.setAttribute('role', 'listbox');
    this.list.hidden = true;
    this.list.addEventListener('mousedown', (evt) => evt.preventDefault());
    this.quill.container.appendChild(this.list);
  }

  isOpen() {
    return !this.list.hidden;
  }

  update() {
    const range = this.quill.getSelection();
    if (!range || range.length > 0) {
      return this.close();
    }

    const from = Math.max(0, range.index - 40);
    const before = this.quill.getContents(from, range.index - from).ops
      .map((op) => (typeof op.insert === 'string' ? op.insert : '￼'))
      .join('');
    const at = before.lastIndexOf(OPEN);
    const typed = at === -1 ? null : before.slice(at + OPEN.length);

    if (typed === null || !CODE.test(typed)) {
      return this.close();
    }

    const search = typed.toLowerCase();
    this.matches = this.fields.filter(({ field }) => field.toLowerCase().startsWith(search));
    if (this.matches.length === 0) {
      return this.close();
    }

    this.start = from + at;
    this.render(range.index);
  }

  render(index) {
    this.list.replaceChildren(...this.matches.map(({ field, description }, i) => {
      const item = document.createElement('li');
      item.className = 'ql-field-item';
      item.setAttribute('role', 'option');

      const code = document.createElement('span');
      code.className = 'ql-field-code';
      code.textContent = field;
      item.appendChild(code);

      if (description) {
        const text = document.createElement('span');
        text.className = 'ql-field-description';
        text.textContent = description;
        item.appendChild(text);
      }

      item.addEventListener('mouseenter', () => this.highlight(i, false));
      item.addEventListener('click', () => this.choose(this.matches[i]));

      return item;
    }));

    const bounds = this.quill.getBounds(index);
    this.list.style.left = `${bounds.left}px`;
    this.list.style.top = `${bounds.bottom + 2}px`;
    this.list.hidden = false;
    this.highlight(0);
  }

  highlight(index, scroll = true) {
    const count = this.matches.length;
    this.active = (index + count) % count;

    Array.from(this.list.children).forEach((item, i) => {
      item.classList.toggle('active', i === this.active);
      item.setAttribute('aria-selected', i === this.active ? 'true' : 'false');
      if (i === this.active && scroll) {
        item.scrollIntoView({ block: 'nearest' });
      }
    });

    return false;
  }

  choose(match) {
    const range = this.quill.getSelection(true);
    const start = this.start;
    this.close();
    if (match && start !== null) {
      this.insert(match.field, start, range.index - start);
    }

    return false;
  }

  close() {
    this.list.hidden = true;
    this.start = null;

    return false;
  }

  buildPicker() {
    const toolbar = this.quill.getModule('toolbar');
    if (!toolbar?.container || this.fields.length === 0) {
      return;
    }

    const group = document.createElement('span');
    group.className = 'ql-formats';

    const button = document.createElement('button');
    button.type = 'button';
    button.className = 'ql-field-picker';
    button.innerHTML = ICON;
    button.setAttribute('aria-haspopup', 'listbox');
    button.setAttribute('aria-label', 'Field');

    const menu = document.createElement('ul');
    menu.className = 'ql-field-list ql-field-menu';
    menu.setAttribute('role', 'listbox');
    menu.hidden = true;

    this.fields.forEach(({ field, description }) => {
      const item = document.createElement('li');
      item.className = 'ql-field-item';
      item.setAttribute('role', 'option');
      item.title = description;

      const code = document.createElement('span');
      code.className = 'ql-field-code';
      code.textContent = field;
      item.appendChild(code);

      item.addEventListener('mousedown', (evt) => evt.preventDefault());
      item.addEventListener('click', () => {
        menu.hidden = true;
        const range = this.quill.getSelection(true);
        this.insert(field, range.index, range.length);
      });
      menu.appendChild(item);
    });

    button.addEventListener('mousedown', (evt) => evt.preventDefault());
    button.addEventListener('click', () => {
      menu.hidden = !menu.hidden;
    });
    document.addEventListener('click', (evt) => {
      if (!group.contains(evt.target)) {
        menu.hidden = true;
      }
    });

    group.append(button, menu);
    toolbar.container.appendChild(group);
  }
}
