@extends('layouts.auth')

@section('css')
<style>
fieldset, label { margin: 0; padding: 0; }
body{ margin: 20px; }
h1 { font-size: 1.5em; margin: 10px; display:block; }

/****** Style Star Rating Widget *****/

.rating { 
 border: none;
 float: left;
  }

.rating > input { display: none; } 
.rating > label:before { 
 margin: 5px;
 font-size: 2em;
 font-family: FontAwesome;
 display: inline-block;
 content: "\f005";
  }

 .rating > .half:before { 
  content: "\f089";
  position: absolute;
   }

   .rating > label { 
    color: #ddd; 
    float: right; 
     }

     /***** CSS Magic to Highlight Stars on Hover *****/

    .rating > input:checked ~ label, /* show gold star when clicked */
     .rating:not(:checked) > label:hover, /* hover current star */
      .rating:not(:checked) > label:hover ~ label { color: #FFD700;  } 
       /*        hover previous stars in list */

       .rating > input:checked + label:hover,
       .rating > input:checked ~ label:hover,
       .rating > label:hover ~ input:checked ~ label, 
       .rating > input:checked ~ label:hover ~ label { color: #FFD700;  }
</style>
@stop

@section('content')
    <img src="{{asset('img/logo_white.jpeg')}}" style="width: 100px; margin-left: auto; margin-right: auto; display: block">
    <h3 class="page-title">Survey Kepuasan Pelanggan</h3>
    {!! Form::open(['method' => 'POST', 'route' => ['survey.store']]) !!}

    <div class="panel panel-default">
        {{ Form::hidden('branch_id', $bon->branch_id)}}
        {{ Form::hidden('income_id', $bon->id)}}
        {{ Form::hidden('template_id', $survey_template->id)}}
        
        <div class="panel-body">
            @for ($i = 1; $i <= $survey_template['no_of_questions']; $i++)
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('q'.$i, $survey_template['q'.$i], ['class' => 'control-label']) !!}<br>
                    <!-- {!! Form::text('q'.$i, old('q'.$i), ['class' => 'form-control', 'placeholder' => '', 'style' => 'text-transform:capitalize', 'autofocus']) !!}     --> 
                    <fieldset class="rating">
                        <input type="radio" id="star5_{{$i}}" name="q{{$i}}" value="5" /><label class = "full" for="star5_{{$i}}" title="Awesome - 5 stars"></label>
                        <!-- <input type="radio" id="star4half_{{$i}}" name="q{{$i}}" value="4 and a half" /><label class="half" for="star4half_{{$i}}" title="Pretty good - 4.5 stars"></label> -->
                        <input type="radio" id="star4_{{$i}}" name="q{{$i}}" value="4" /><label class = "full" for="star4_{{$i}}" title="Pretty good - 4 stars"></label>
                       <!--  <input type="radio" id="star3half_{{$i}}" name="q{{$i}}" value="3 and a half" /><label class="half" for="star3half_{{$i}}" title="Meh - 3.5 stars"></label> -->
                        <input type="radio" id="star3_{{$i}}" name="q{{$i}}" value="3" /><label class = "full" for="star3_{{$i}}" title="Meh - 3 stars"></label>
                        <!-- <input type="radio" id="star2half_{{$i}}" name="q{{$i}}" value="2 and a half" /><label class="half" for="star2half_{{$i}}" title="Kinda bad - 2.5 stars"></label> -->
                        <input type="radio" id="star2_{{$i}}" name="q{{$i}}" value="2" /><label class = "full" for="star2_{{$i}}" title="Kinda bad - 2 stars"></label>
                       <!--  <input type="radio" id="star1half_{{$i}}" name="q{{$i}}" value="1 and a half" /><label class="half" for="star1half_{{$i}}" title="Meh - 1.5 stars"></label> -->
                        <input type="radio" id="star1_{{$i}}" name="q{{$i}}" value="1" /><label class = "full" for="star1_{{$i}}" title="Sucks big time - 1 star"></label>
                        <!-- <input type="radio" id="starhalf_{{$i}}" name="q{{$i}}" value="half" /><label class="half" for="starhalf_{{$i}}" title="Sucks big time - 0.5 stars"></label> -->
                    </fieldset>             
                </div>
            </div>
            @endfor

            
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('essay', $survey_template['essay'], ['class' => 'control-label']) !!}
                    {!! Form::textarea('essay', old('essay'), ['class' => 'form-control ', 'placeholder' => '', 'rows' => '2', 'id' => 'note']) !!}
                    
                </div>
            </div>
           
            
            
        </div>
    </div>

    {!! Form::submit('Kirim', ['class' => 'btn btn-success btn-lg']) !!}
    {!! Form::close() !!}
@stop
