/**
 * Use this file for JavaScript code that you want to run in the front-end
 * on posts/pages that contain this block and wherever the shortcode is used.
 *
 * When this file is defined as the value of the `viewScript` property
 * in `block.json` it will be enqueued on the front end of the site.
 *
 * Example:
 *
 * ```js
 * {
 *   "viewScript": "script-handle"
 * }
 * ```
 *
 * If you're not making any changes to this file because your project doesn't need any
 * JavaScript running in the front-end, then you should delete this file and remove
 * the `viewScript` property from `block.json`.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-metadata/#view-script
 */

jQuery(document).ready(function ($) {
  console.log("Wuff! Hello from the front-end!");
	const cssClasses = [
		"wouf-ucfirst",
		"wouf-uppercase",
		"wouf-lowercase",
		"wouf-small",
		"wouf-large",
		"wouf-xlarge",
	];

	function getRandomClass() {
		// Randomly select one CSS class
		const randomIndex = Math.floor(Math.random() * cssClasses.length);
		return cssClasses[randomIndex];
	}

	// Function to append "Wouf!" to the paragraph
	function appendWouf() {
		// Find the paragraph element inside the blockquote
		const $blockquote = $(".rrze-hello-lenny p");
		if ($blockquote.length === 0) {
			return; // Exit if the blockquote element is not found
		}

		// Create a new span element with the "Wouf!" text and set the class attribute
		const $span = $("<span>").text("Wouf!").attr("class", getRandomClass());

		// Append the new span to the paragraph
		$blockquote.append($span).append(" "); // Add a space after the "Wouf!"
	}

	// Function to schedule the appending of "Wouf!" after a random delay
	function scheduleWouf() {
		const randomDelay = Math.floor(Math.random() * 5000) + 1000; // Random delay between 1s and 5s
		setTimeout(function () {
			appendWouf();
			scheduleWouf(); // Schedule the next "Wouf!" append
		}, randomDelay);
	}

	// Start the initial "Wouf!" scheduling
	scheduleWouf();
});
