/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from "@wordpress/i18n";

/**
 * Import all the components we need from the WordPress library.
 * You can find a complete list with components here: https://wordpress.github.io/gutenberg/?path=/docs/docs-introduction--page
 */
import { PanelBody, PanelRow, TextControl } from "@wordpress/components";

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import {
	InspectorControls,
	PanelColorSettings,
	ContrastChecker,
	useBlockProps,
} from "@wordpress/block-editor";

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import "./editor.scss";

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function Edit({ attributes, setAttributes }) {
	const { cssClasses, backgroundColor, borderColor, textColor } = attributes;

	// Update attribute values.
	const onChangeCssClasses = (newCssClasses) => {
		setAttributes({ cssClasses: newCssClasses });
	};

	const onChangeBackgroundColor = (newBackgroundColor) => {
		setAttributes({ backgroundColor: newBackgroundColor });
	};

	const onChangeBorderColor = (newBorderColor) => {
		setAttributes({ borderColor: newBorderColor });
	};

	const onChangeTextColor = (newTextColor) => {
		setAttributes({ textColor: newTextColor });
	};

	// Apply styles and classes to the block.
	const blockProps = useBlockProps({
		className: cssClasses,
		style: {
			backgroundColor: backgroundColor,
			borderColor: borderColor,
			borderStyle: "solid",
			color: textColor,
		},
	});

	return (
		<div {...blockProps}>
			<InspectorControls>
				<PanelColorSettings
					title={__("Color Settings", "rrze-hello-lenny")}
					initialOpen={true}
					colorSettings={[
						{
							value: backgroundColor,
							onChange: onChangeBackgroundColor,
							label: __("Background Color", "rrze-hello-lenny"),
						},
						{
							value: borderColor,
							onChange: onChangeBorderColor,
							label: __("Border Color", "rrze-hello-lenny"),
						},
						{
							value: textColor,
							onChange: onChangeTextColor,
							label: __("Text Color", "rrze-hello-lenny"),
						},
					]}
				>
					<ContrastChecker
						textColor={textColor} // Assuming text color is black
						backgroundColor={backgroundColor}
					/>
				</PanelColorSettings>
			</InspectorControls>
			<blockquote lang="de">
				<p>
					<span className="wouf-ucfirst">
						{__("Wuff!", "rrze-hello-lenny")}
					</span>
					<span className="wouf-ucfirst wouf-uppercase">
						{__("Wuff!", "rrze-hello-lenny")}
					</span>
				</p>
				<cite>🐶 Lenny</cite>
			</blockquote>
		</div>
	);
}
