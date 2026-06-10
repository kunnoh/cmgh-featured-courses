// /**
//  * Retrieves the translation of text.
//  *
//  * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
//  */
// import { __ } from '@wordpress/i18n';

// /**
//  * React hook that is used to mark the block wrapper element.
//  * It provides all the necessary props like the class name.
//  *
//  * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
//  */
// import { useBlockProps } from '@wordpress/block-editor';

// /**
//  * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
//  * Those files can contain any CSS code that gets applied to the editor.
//  *
//  * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
//  */
// import './editor.scss';

// /**
//  * The edit function describes the structure of your block in the context of the
//  * editor. This represents what the editor will render when the block is used.
//  *
//  * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
//  *
//  * @return {Element} Element to render.
//  */
// export default function Edit() {
// 	return (
// 		<p { ...useBlockProps() }>
// 			{ __(
// 				'Cmgh Featured Courses – hello from the editor!',
// 				'cmgh-featured-courses'
// 			) }
// 		</p>
// 	);
// }

import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, RangeControl } from '@wordpress/components';

export default function Edit({ attributes, setAttributes }) {
    const { limit } = attributes;
    const blockProps = useBlockProps({
        className: 'cmgh-featured-courses-placeholder',
    });

    return (
        <>
            <InspectorControls>
                <PanelBody title={__('Settings', 'cmgh-featured-courses')}>
                    <RangeControl
                        label={__('Number of Courses', 'cmgh-featured-courses')}
                        value={limit}
                        onChange={(val) => setAttributes({ limit: val })}
                        min={1}
                        max={12}
                    />
                </PanelBody>
            </InspectorControls>

            <div {...blockProps}>
                <p><strong>CMGH Featured Courses Block</strong></p>
                <p>Showing up to {limit} courses on the frontend.</p>
                <p><em>Live preview only appears on the published page.</em></p>
            </div>
        </>
    );
}