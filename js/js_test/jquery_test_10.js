function add_html(str)
{
    var show_info = $('#show_info').html();
    show_info += str+'<br>';
    $('#show_info').html(str);
}

window.onload = function(){
    add_html('window.onload = function(){};');
    console.log('window.onload = function(){};');
};

$(window).load(function(){
    add_html('$(window).load(function(){});');
    console.log('$(window).load(function(){});');
});

$(function(){
    add_html('$(function(){});');
    console.log('$(function(){});');
});

$(document).ready(function(){
    add_html('$(document).ready(function(){});');
    console.log('$(document).ready(function(){});');
}).load(function(){
    add_html('$(document).load(function(){});');
    console.log('$(document).load(function(){});');
}).unload(function(){
    add_html('$(document).unload(function(){});');
    console.log('$(document).unload(function(){});');
});

$(function(){
    add_html('$(function(){});part2');
    console.log('$(function(){});part2');
});