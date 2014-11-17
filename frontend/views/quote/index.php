<?php
/**
 * Created by PhpStorm.
 * User: bob
 * Date: 14/11/17
 * Time: 上午10:24
 */

$js = <<<JS
           $('#quote-of-the-day').click(function(){
             $.ajax({
                url: '/quote?random=1',
                success: function(data) {
                    $("#quote").html(data.quote);
                    $("#author").html(data.author);
                }
        })
    });
JS;

$this->registerJs($js);
$this->title = "Quote of the day - iDarex";
?><h2 style="margin-top:60px; color: #ffffff;">Quote of the day<small style="font-size:12px;"> Tip: Click the quote can change quote.</small></h2>
<div id="quote-of-the-day" style="cursor: pointer; font-size: 16px; color: #ffffff;" title="click to change quote">
    <p>&ldquo;<span id="quote"><?= $quote['quote']?></span>&rdquo; </p>
    <p align="right">—— <span id="author"></span><?= $quote['author']?></span></p>
</div>