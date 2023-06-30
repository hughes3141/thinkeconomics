    <!-- The iniput form for selecting subject and topics:-->

    <form method="get" action = "">
        <div id="accordion-collapse" data-accordion="collapse" class="my-2 border rounded-xl border-gray-200 mt-2">
          <h2 id="accordion-collapse-heading-1">
            <button type="button" class="flex items-center justify-between w-full p-5 font-medium text-left rounded-t-xl focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800" data-accordion-target="#accordion-collapse-body-1" aria-expanded="<?=(is_null($subjectLevel)) ? "true" : "false"?>" aria-controls="accordion-collapse-body-1">
              <span>Select Subject and Level</span>
              <svg data-accordion-icon class="w-6 h-6  shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            </button>
          </h2>
          <div id="accordion-collapse-body-1" class="hidden" aria-labelledby="accordion-collapse-heading-1">
            <div class="p-5  border-b-0 border-gray-200 dark:border-gray-700 dark:bg-gray-900">
              <div>
                <label for="subjectLevel">Subject:</label>
                <select class="mb-3" id="subjectLevel" name="subjectLevel" onchange="this.form.submit()">
                  <option value="_"></option>
                  <?php
                    foreach ($subjects as $subject) {
                      $subjectLevelId = $subject['lId']."_".$subject['sId'];
                      ?>
                      <option value="<?=$subjectLevelId?>" <?=($subjectLevelId == $subjectLevel) ? "selected" : ""?>><?=$subject['subject']?> (<?=$subject['level']?>)</option>
                      <?php
                    }
                    ?>

                </select>

                <input type="submit" value="Choose Subject" class="rounded border border-sky-300 bg-sky-300 w-full text-white mt-2 hover:bg-sky-200">
                

              </div>
            </div>
          </div>
          <h2 id="accordion-collapse-heading-2">
            <button type="button" class="flex items-center justify-between w-full p-5 font-medium text-left  text-gray-500  border-b-0 border-gray-200 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800" data-accordion-target="#accordion-collapse-body-2" aria-expanded="<?=(is_null($topics) or $topics == "") ? "true" : "false" ?>" aria-controls="accordion-collapse-body-2">
              <span>Select Topics</span>
              <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            </button>
          </h2>
          <div id="accordion-collapse-body-2" class="hidden rounded-b-xl" aria-labelledby="accordion-collapse-heading-2">
            <div class="p-5  border-gray-200 dark:border-gray-700">
              <div class="grid grid-cols-4">
                <?php
                  $topics = explode(",", $topics);
                  //print_r($topics);
                  
                  foreach($topicsArray as $topic) {
                    ?>
                    <div>
                      <input type="checkbox" id="topic_<?=htmlspecialchars($topic)?>" class= "topicSelector" value="<?=htmlspecialchars($topic)?>" onchange="topicAggregate();" <?php
                        if(count($topics)>0 && $topics[0] != "") {
                          //if(in_array($topic, $topics)) {
                          if(startsWithAny($topic, $topics)) {
                            echo "checked";
                          }
                        } 
                      ?>>
                      <label for = "topic_<?=htmlspecialchars($topic)?>" ><?=htmlspecialchars($topic)?></label>
                    </div>
                    <?php
                  }

                ?>

              </div>
              <?php
              if(count($topicsArray)>0) {
              ?>
                <input type="hidden" name="topics" id="topicSelect">
                <input type="submit" value="Choose Topics" class="rounded border border-sky-300 bg-sky-300 w-full mt-2 text-white hover:bg-sky-200">
              <?php
              }
              ?>

            </div>
          </div>
          <?php 
          /*
          <h2 id="accordion-collapse-heading-3">
            <button type="button" class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-gray-200 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800" data-accordion-target="#accordion-collapse-body-3" aria-expanded="false" aria-controls="accordion-collapse-body-3">
              <span>What are the differences between Flowbite and Tailwind UI?</span>
              <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            </button>
          </h2>
          <div id="accordion-collapse-body-3" class="hidden" aria-labelledby="accordion-collapse-heading-3">
            <div class="p-5 border border-t-0 border-gray-200 dark:border-gray-700">
              <p class="mb-2 text-gray-500 dark:text-gray-400">The main difference is that the core components from Flowbite are open source under the MIT license, whereas Tailwind UI is a paid product. Another difference is that Flowbite relies on smaller and standalone components, whereas Tailwind UI offers sections of pages.</p>
              <p class="mb-2 text-gray-500 dark:text-gray-400">However, we actually recommend using both Flowbite, Flowbite Pro, and even Tailwind UI as there is no technical reason stopping you from using the best of two worlds.</p>
              <p class="mb-2 text-gray-500 dark:text-gray-400">Learn more about these technologies:</p>
              <ul class="pl-5 text-gray-500 list-disc dark:text-gray-400">
                <li><a href="https://flowbite.com/pro/" class="text-blue-600 dark:text-blue-500 hover:underline">Flowbite Pro</a></li>
                <li><a href="https://tailwindui.com/" rel="nofollow" class="text-blue-600 dark:text-blue-500 hover:underline">Tailwind UI</a></li>
              </ul>
            </div>
          </div>
          */
          ?>
        </div>
      </form>

<script>

topicAggregate();

function topicAggregate() {

  var topicsInput = document.getElementsByClassName("topicSelector");
  var topicsInputChecked = [];
  var topicString = "";
  var checkedCount = 0;
  const topicSelect = document.getElementById("topicSelect");

  for (var i=0; i<topicsInput.length; i++) {
    var topic = topicsInput[i];
    if(topic.checked == true) {
      topicsInputChecked.push(topicsInput[i]);
    }
  }

  for(var i=0; i<topicsInputChecked.length; i++) {
    topic = topicsInputChecked[i];
    topicString += topic.value;
    if(i < (topicsInputChecked.length - 1)) {
      topicString += ",";
    }

  }

  topicSelect.value = topicString;

  //console.log(topicString);
  //console.log(topicSelect);
  topicSelect.value = topicString;
}
</script>