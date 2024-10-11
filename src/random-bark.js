jQuery(document).ready(function($) {
    const cssClasses = [
        'wouf-ucfirst',
        'wouf-uppercase',
        'wouf-lowercase',
        'wouf-small',
        'wouf-large',
        'wouf-xlarge'
    ];

    function getRandomClasses() {
        const numClasses = Math.floor(Math.random() * cssClasses.length) + 1;
        const selectedClasses = [];

        for (let i = 0; i < numClasses; i++) {
            const randomIndex = Math.floor(Math.random() * cssClasses.length);
            selectedClasses.push(cssClasses[randomIndex]);
        }

        return selectedClasses.join(' ');
    }

    // Function to append "Wouf!" to the paragraph
    function appendWouf() {
        // Find the paragraph element inside the blockquote
        const $blockquote = $('.rrze-hello-lenny p');
        if ($blockquote.length === 0) {
            return; // Exit if the blockquote element is not found
        }

        // Create a new span element with the "Wouf!" text
        const $span = $('<span>').text('Wouf!').addClass(getRandomClasses());

        // Append the new span to the paragraph
        $blockquote.append($span).append(' '); // Add a space after the "Wouf!"
    }

    // Function to schedule the appending of "Wouf!" after a random delay
    function scheduleWouf() {
        const randomDelay = Math.floor(Math.random() * 5000) + 1000; // Random delay between 1s and 5s
        setTimeout(function() {
            appendWouf();
            scheduleWouf(); // Schedule the next "Wouf!" append
        }, randomDelay);
    }

    // Start the initial "Wouf!" scheduling
    scheduleWouf();
});
