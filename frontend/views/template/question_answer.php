<section id="question">
     <div class="text-center">
          <h2>Những câu hỏi thường gặp</h2>
     </div>
     <div class="list_question">
          <?php 
               if(!empty($arr_ques)) { 
                    foreach($arr_ques as $key => $ques) {      
          ?>
                    <div class="general">
                         <span class="mb-3 fz-20 d-block"><?= $key ?></span>
                         <?php foreach($ques as $item) { ?>
                         <div class="question_child">
                              <div class="question_tit">
                                   <p class="font-weight-bold"><?= $item['question'] ?></p>
                                   <i class="fas fa-angle-down"></i>
                              </div>
                              <div class="answer_h">
                                   <p><?= $item['answer'] ?></p>
                              </div>
                         </div>
                         <?php } ?>
                    </div>
          <?php }} ?>
     </div>
</section>