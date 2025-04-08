@extends('layouts.myapp')
@section('content')
<script src="{{ asset('js/orgchart.js') }}"></script>
<main id="main" class="main">
      <div id="tree"></div>
    </main>

@if (isset($network))
    <script>
        console.log('{!! $network !!}')
      OrgChart.templates.olivia.field_2 =
        '<text data-width="50" style="font-size: 14px;" fill="#757575" x="195" y="100">{val}</text>';

      var chart = new OrgChart(document.getElementById("tree"), {
        // enableTouch: true,
        nodeBinding: {
          field_0: "login",
          field_1: "name",
          field_2: "btn",
          img_0: "img"
        },
        template: "olivia",
        editForm: {
          addMore: 'Add more elements',
          addMoreBtn: 'Add element',
          addMoreFieldName: 'Element name',
        },
        tags: {
          "Inactive": {},
        },
        nodes: {!! $network !!}
      });
    </script>
  @endif
@endsection
