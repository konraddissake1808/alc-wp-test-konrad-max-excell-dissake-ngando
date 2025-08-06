import { useBlockProps, RichText } from '@wordpress/block-editor';

export default function save({ attributes }) {
  const { title, text, url, backgroundColor } = attributes;

  return (
    <div {...useBlockProps.save({ style: { backgroundColor }, 'aria-label': 'Call to action banner' })}>
      <RichText.Content tagName="h2" value={title} />
      <RichText.Content tagName="p" value={text} />
      <a href={url} className="cta-button" role="button" tabIndex="0">Learn More</a>
    </div>
  );
}
