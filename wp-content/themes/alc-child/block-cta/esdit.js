import { __ } from '@wordpress/i18n';
import { useBlockProps, RichText, InspectorControls, URLInput } from '@wordpress/block-editor';
import { PanelBody, ColorPicker } from '@wordpress/components';

export default function Edit({ attributes, setAttributes }) {
  const { title, text, url, backgroundColor } = attributes;

  return (
    <>
      <InspectorControls>
        <PanelBody title="Settings">
          <p>Background Color</p>
          <ColorPicker
            color={backgroundColor}
            onChangeComplete={(value) => setAttributes({ backgroundColor: value.hex })}
            disableAlpha
          />
        </PanelBody>
      </InspectorControls>
      <div {...useBlockProps({ style: { backgroundColor } })}>
        <RichText
          tagName="h2"
          value={title}
          onChange={(val) => setAttributes({ title: val })}
          placeholder="Title"
        />
        <RichText
          tagName="p"
          value={text}
          onChange={(val) => setAttributes({ text: val })}
          placeholder="Description"
        />
        <URLInput
          value={url}
          onChange={(val) => setAttributes({ url: val })}
        />
      </div>
    </>
  );
}
