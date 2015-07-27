$(document).ready(function(){
    $('#test_div')
        .append('<div class="test">1. Append</div>')
        .prepend('<div class="test">2. Prepend</div>')
        .before('<div class="test">3. Before</div>')
        .after('<div class="test">4. After</div>')
        .children('div[class!="test"]').html('<div></div>').addClass('test').text('5. children html addClass text');
});