<div class="container">
    <div class="bread-crumbs">

        @php
            $html = '';
            foreach ($breadcrumbs as $key => $item) {
                if (isset($item['url'])) {
                    $html .= '<a href="' . $item['url'] . '">' . $item['name'] . '</a>';
                } else {
                    $html .= $item['name'];
                }

                if ($key < count($breadcrumbs) - 1) {
                    $html .= '<span>/</span>';
                }
            }
        @endphp

        {!! $html !!}
    </div>
</div>
