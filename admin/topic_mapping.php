<?php

$publicPage = true;
$path = $_SERVER['DOCUMENT_ROOT'];
include($path."/php_header.php");
include($path."/php_functions.php");

// --- Fetch full topic tree ---
$topicsById = array();
$result = $conn->query("SELECT id, name, parent_id, sort_order FROM topics_master ORDER BY sort_order, id");
while ($row = $result->fetch_assoc()) {
  $row['children'] = array();
  $topicsById[$row['id']] = $row;
}

$branches = array();
foreach ($topicsById as $id => $row) {
  if ($row['parent_id'] === null) {
    $branches[] = $id;
  } else {
    $topicsById[$row['parent_id']]['children'][] = $id;
  }
}

// --- Fetch exam boards, in a fixed display order (Eduqas/WJEC grouped together since they're the same spec) ---
$boardOrder = array();
$result = $conn->query("SELECT id, name FROM exam_boards");
$boardsById = array();
while ($row = $result->fetch_assoc()) {
  $boardsById[$row['id']] = $row['name'];
}
$displayOrder = array('Eduqas', 'WJEC', 'AQA', 'Edexcel/Pearson', 'OCR', 'CIE', 'IB (International Baccalaureate)');
foreach ($displayOrder as $name) {
  $foundId = array_search($name, $boardsById);
  if ($foundId !== false) {
    $boardOrder[] = $foundId;
  }
}

// --- Fetch all cross-reference rows, keyed by [topic_id][exam_board_id][] ---
$mapData = array();
$result = $conn->query("SELECT topic_id, exam_board_id, topic_code, topic_name FROM topics_exam_board_map ORDER BY id");
while ($row = $result->fetch_assoc()) {
  $mapData[$row['topic_id']][$row['exam_board_id']][] = array('code' => $row['topic_code'], 'name' => $row['topic_name']);
}

$style_input = "

  th, td {
    border-bottom: 1px solid #cbd5e1;
    border-right: 1px solid #cbd5e1;
    padding: 6px 8px;
    vertical-align: top;
  }

  table {
    border-collapse: separate;
    border-spacing: 0;
    border-top: 1px solid #cbd5e1;
    border-left: 1px solid #cbd5e1;
  }

  thead th, .branch-row, .family-row {
    height: 40px;
    white-space: nowrap;
    box-sizing: border-box;
  }

";

include($path."/header_tailwind.php");

?>

<div class="container mx-auto px-4 mt-20 lg:mt-32 xl:mt-20">
  <h1 class="font-mono text-2xl bg-pink-400 pl-1">Exam Board Topic Mapping</h1>

  <div class="container mx-auto p-4 mt-2 bg-white text-black mb-5">

    <div class="border-2 rounded border-sky-200 p-3 mb-4">
      <p class="mb-2">Every exam board organises A Level Economics a little differently — some group topics broadly, others break them into fine detail, and the wording is never quite the same from one specification to another. To make it possible to use the same set of resources and questions whichever board you're following, we've built a single <strong>master topic list</strong> that every specification maps onto.</p>
      <p class="mb-2">Find your exam board's column in the table below. Wherever your specification lists a topic, you'll see which master topic it corresponds to — and its official topic code, where the board publishes one. This is also how our question bank and revision resources are organised, so it's worth knowing which master topic matches whatever you're currently studying, even if your own specification calls it something slightly different.</p>
      <p>Where a cell is blank, that board's specification doesn't have a directly equivalent topic — that's expected, not a mistake; boards genuinely differ in what they cover and at what level of detail.</p>
    </div>

    <div class="mb-3">
      <span class="font-mono">Jump to:</span>
      <a class="underline hover:bg-sky-100 text-sky-700 mr-2" href="#branch-microeconomics">Microeconomics</a>
      <a class="underline hover:bg-sky-100 text-sky-700 mr-2" href="#branch-macroeconomics">Macroeconomics</a>
      <a class="underline hover:bg-sky-100 text-sky-700" href="#branch-global-economics">Global economics</a>
    </div>

    <div class="overflow-auto border border-sky-200 rounded" style="max-height: 75vh;">
      <table class="w-full text-sm">
        <thead>
          <tr class="sticky top-0 z-50 bg-sky-100">
            <th class="text-left sticky left-0 top-0 z-[60] bg-sky-100">Master Topic</th>
            <?php foreach ($boardOrder as $boardId) { ?>
              <th class="text-left"><?=$boardsById[$boardId]?></th>
            <?php } ?>
          </tr>
        </thead>
        <tbody>
          <?php

          function renderTopicRow($topicId, $topicsById, $mapData, $boardOrder, $depth) {
            $topic = $topicsById[$topicId];
            $indent = $depth * 20;
            ?>
            <tr>
              <td style="padding-left: <?=(8 + $indent)?>px;" class="sticky left-0 z-0 bg-white <?=($depth == 0) ? "font-semibold" : ""?>"><?=$topic['name']?></td>
              <?php foreach ($boardOrder as $boardId) { ?>
                <td>
                  <?php
                  if (isset($mapData[$topicId][$boardId])) {
                    foreach ($mapData[$topicId][$boardId] as $i => $entry) {
                      if ($i > 0) echo "<hr class='my-1 border-slate-200'>";
                      if ($entry['code']) {
                        echo "<span class='font-mono text-xs bg-pink-100 px-1 rounded'>".htmlspecialchars($entry['code'])."</span> ";
                      }
                      echo htmlspecialchars($entry['name']);
                    }
                  }
                  ?>
                </td>
              <?php } ?>
            </tr>
            <?php
            foreach ($topic['children'] as $childId) {
              renderTopicRow($childId, $topicsById, $mapData, $boardOrder, $depth + 1);
            }
          }

          foreach ($branches as $branchId) {
            $branch = $topicsById[$branchId];
            $anchorId = "branch-" . strtolower(str_replace(" ", "-", $branch['name']));
            ?>
            <tr id="<?=$anchorId?>">
              <td colspan="<?=count($boardOrder) + 1?>" class="bg-pink-400 text-white font-mono text-lg"><?=$branch['name']?></td>
            </tr>
            <?php
            foreach ($branch['children'] as $familyId) {
              $family = $topicsById[$familyId];
              ?>
              <tr>
                <td colspan="<?=count($boardOrder) + 1?>" class="bg-sky-200 font-mono"><?=$family['name']?></td>
              </tr>
              <?php
              foreach ($family['children'] as $topicIdInFamily) {
                renderTopicRow($topicIdInFamily, $topicsById, $mapData, $boardOrder, 0);
              }
            }
          }
          ?>
        </tbody>
      </table>
    </div>

  </div>
</div>

<?php include($path."/footer_tailwind.php"); ?>
