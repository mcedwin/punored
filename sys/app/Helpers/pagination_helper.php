<?php

// This data will go to the pagination view. $data(by reference)
function setPaginationData(?array &$data, $quant_results, $quant_to_show, $page)
{
    if ($page < 1 || ($page - 1) * $quant_to_show > $quant_results) $page = 1;
    $data['current_page'] = $page--;
    $num_pages = (int)($quant_results / $quant_to_show);
    $data['last_page'] = $num_pages + (($quant_results % $quant_to_show == 0) ? 0 : 1);
    
    return array(
        'num_pages' => $num_pages,
        'start_from_page' => $page * $quant_to_show,
    );
}

function loadPagination(?int $current, ?int $last, ?string $path, ?string $params = null)
{
  $html = 
    "<nav aria-label='...''>
        <ul class='pagination justify-content-center'>";
  $prev =
    "<li class='page-item " . (($current <= 1) ? 'disabled' : '') . "'>
        <a class='page-link' href='$path/" . ($current - 1) . $params . "'>Anterior</a>
    </li>";
  $next =
    "<li class='page-item " . (($current >= $last || !$last) ? 'disabled' : '') . "'>
        <a class='page-link' href='$path/" . ($current + 1) . $params . "'>Siguiente</a>
    </li>";
  $html .= $prev;

  if ($last <= 10) {
    for ($i = 1; $i <= $last; $i++) {
      $html .=
        "<li class='page-item " . (($current == $i) ? 'active' : '') . "'>
          <a class='page-link' href='$path/$i" . $params . "'>$i</a>
        </li>";
    }
  } else {
    if ($current - 2 <= 3) {
      $carry = 1;
      if ($current < 2) $carry = 2;
      for ($i = 1; $i <= $current + $carry; $i++) {
        $html .=
        "<li class='page-item " . (($current == $i) ? 'active' : '') . "'>
        <a class='page-link' href='$path/$i" . $params . "'>$i</a>
        </li>";
      }
      $html .= lastItems($path, $params, $last, 3);
    }
    if ($current - 2 > 3 && $current + 2 < $last - 2) {
      $html .= firstItems($path, $params, $last, 3);
      for ($i = $current - 1; $i <= $current + 1; $i++) {
        $html .=
          "<li class='page-item " . (($current == $i) ? 'active' : '') . "'>
            <a class='page-link' href='$path/$i" . $params . "'>$i</a>
          </li>";
      }
      $html .= lastItems($path, $params, $last, 3);
    }
    if ($current + 2 >= $last - 2) {
      $html .= firstItems($path, $params, $last, 3);
      $carry = 1;
      if ($current > $last - 1) $carry = 2;
      for ($i = $current - $carry; $i <= $last; $i++) {
        $html .=
          "<li class='page-item " . (($current == $i) ? 'active' : '') . "'>
            <a class='page-link' href='$path/$i" . $params . "'>$i</a>
          </li>";
      }
    }
  }

  $html .= $next;

  $html .=
        "</ul>
    </nav>";
  return $html;
}

function firstItems(?string $path, ?string $params, ?int $last, ?int $quant = 3) : string
{
  $html = '';
  for ($i = 1; $i <= $quant && $i <= $last; $i++) {
    $html .=
      "<li class='page-item'>
        <a class='page-link' href='$path/$i" . $params . "'>$i</a>
      </li>";
  }
  $html .= '<span class="page-link border-0">...</span>';
  return $html;
}

function lastItems(?string $path, ?string $params, ?int $last, ?int $quant = 3) : string
{
  $html = '<span class="page-link border-0">...</span>';
  for ($i = $last - $quant + 1; $i <= $last; $i++) {
    $html .=
      "<li class='page-item'>
        <a class='page-link' href='$path/$i" . $params . "'>$i</a>
      </li>";
  }
  return $html;
}
