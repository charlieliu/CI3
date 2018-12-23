{content}
<tr>
    <td id="question_{key}">{value_1} {mark} {value_2} = </td>
    <td class="content_value">
        <input id="answer_{key}" type="number" value="{answer}" style="display:none;">
        <input id="solution_{key}" type="text" value="" style="padding-left:5px;" onchange="check({key})">
    </td>
</tr>
{/content}
<script>
function check(key)
{
    var solution = $('#solution_'+key).val(),
        answer = $('#answer_'+key).val();
        console.log('check', key, solution, answer);
    if (solution != answer)
    {
        $('#question_'+key).css('color', 'red');
    }
    else{
        $('#question_'+key).css('color', 'green');
    }
}
</script>