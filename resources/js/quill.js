import Quill from 'quill/core';

import { AlignClass, AlignStyle } from 'quill/formats/align';
import Indent from 'quill/formats/indent';

import { BackgroundClass, BackgroundStyle } from 'quill/formats/background';
import { ColorClass, ColorStyle } from 'quill/formats/color';

import List from 'quill/formats/list';

import Toolbar from 'quill/modules/toolbar';
import Snow from 'quill/themes/snow';
import Bubble from 'quill/themes/bubble';

import Bold from 'quill/formats/bold';
import Header from 'quill/formats/header';
import Image from 'quill/formats/image';
import Italic from 'quill/formats/italic';
import Link from 'quill/formats/link';
import Strike from 'quill/formats/strike';
import Underline from 'quill/formats/underline';

import Icons from 'quill/ui/icons';
import Picker from 'quill/ui/picker';
import ColorPicker from 'quill/ui/color-picker';
import IconPicker from 'quill/ui/icon-picker';
import Tooltip from 'quill/ui/tooltip';

import BlotFormatter from '@enzedonline/quill-blot-formatter2';

Quill.register({
  'attributors/class/align': AlignClass,
  'attributors/class/background': BackgroundClass,
  'attributors/class/color': ColorClass,

  'attributors/style/align': AlignStyle,
  'attributors/style/background': BackgroundStyle,
  'attributors/style/color': ColorStyle,
  
}, true);

Quill.register({
  'formats/align': AlignClass,
  'formats/indent': Indent,

  'formats/background': BackgroundStyle,
  'formats/color': ColorStyle,

  'formats/list': List,

  'formats/bold': Bold,
  'formats/header': Header,
  'formats/image': Image,
  'formats/italic': Italic,
  'formats/link': Link,
  'formats/strike': Strike,
  'formats/underline': Underline,

  'modules/toolbar': Toolbar,
  'modules/blotFormatter2': BlotFormatter,

  'themes/snow': Snow,
  'themes/bubble': Bubble,

  'ui/icons': Icons,
  'ui/picker': Picker,
  'ui/icon-picker': IconPicker,
  'ui/color-picker': ColorPicker,
  'ui/tooltip': Tooltip
}, true);

const Delta = Quill.import('delta');

const uploadImage = async (url, file) => {
  const body = new FormData();
  body.append('image', file);

  const response = await fetch(url, {
    method: 'POST',
    body,
    credentials: 'same-origin',
    headers: {
      Accept: 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ?? '',
    },
  });

  if (!response.ok) {
    throw new Error(`The image could not be uploaded (${response.status}).`);
  }

  return (await response.json()).url;
};

const readAsDataUrl = (file) => new Promise((resolve) => {
  const reader = new FileReader();
  reader.onload = () => resolve(reader.result);
  reader.readAsDataURL(file);
});

const imageUploader = (uploadUrl) => ({
  mimetypes: ['image/png', 'image/jpeg', 'image/gif', 'image/webp'],
  handler(range, files) {
    Promise.all(files.map((file) => uploadImage(uploadUrl, file).catch((error) => {
      console.error(error);

      return readAsDataUrl(file);
    }))).then((images) => {
      const update = images.reduce(
        (delta, image) => delta.insert({ image }),
        new Delta().retain(range.index).delete(range.length),
      );

      this.quill.updateContents(update, Quill.sources.USER);
      this.quill.setSelection(range.index + images.length, Quill.sources.SILENT);
    });
  },
});

const blotFormatterOptions = {
  toolbar: {
    buttonStyle: {
      background: 'var(--bg-surface, var(--tblr-bg-surface, #fff))',
      border: '1px solid var(--border-color, var(--tblr-border-color, #999))',
    },
    buttonSelectedStyle: {
      filter: 'none',
    },
    svgStyle: {
      background: 'transparent',
    },
  },
};

export default function registerQuill({ uploadUrl = null } = {}) {
  class QuillWithBlotFormatter extends Quill {
    constructor(container, options = {}) {
      super(container, {
        ...options,
        modules: {
          blotFormatter2: options.readOnly ? false : blotFormatterOptions,
          ...(uploadUrl ? { uploader: imageUploader(uploadUrl) } : {}),
          ...(options.modules ?? {}),
        },
      });
    }
  }

  window.Quill = QuillWithBlotFormatter;

  return QuillWithBlotFormatter;
}
