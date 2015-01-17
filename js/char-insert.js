var input_position = 0, last_input = false;
// if the input[type="text"] or textarea has a keyup or mouseup event then run this
$('input[type="text"]').on('keyup mouseup', function () {
    last_input = $(this);
    // gets the last input's position
    if('selectionStart' in this) {
        input_position = this.selectionStart;
    } else if('selection' in document) {
        this.focus();
        var Sel = document.selection.createRange();
        var SelLength = document.selection.createRange().text.length;
        Sel.moveStart('character', -this.value.length);
        input_position = Sel.text.length - SelLength;
    }
});

$('button.insert-word').click(function () {
    if(!last_input) return; // if an input wasn't selected don't run
    var last_input_value = last_input.val(); // value of input
    var word_to_insert = this.value; // value of button
    // split the last input's value then insert the word
    last_input.val([
        last_input_value.slice(0, input_position),
        word_to_insert,
        last_input_value.slice(input_position)
    ].join(''));
});