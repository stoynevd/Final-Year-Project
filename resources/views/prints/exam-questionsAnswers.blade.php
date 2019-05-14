<html>
    <head>
        <title> Exam </title>
        <meta charset="utf-8">
    </head>
    <body>
    <h2 style="text-align: center;"> {{ $exam->name }} </h2>
    @foreach($exam->sections as $key => $section)
        <h4 style="text-align: center;"> Section #{{ $key + 1 }} -  {{ $section->name }} </h4>
        @foreach($section->questions as $key2 => $question)
            @if($question->moduleQuestion->type == 'Open')
                <h5> {{ ($key2 + 1).'. '.$question->moduleQuestion->text }} </h5>
                Answer: ....................
            @elseif($question->moduleQuestion->type == 'Multiple')
                <h5> {{ ($key2 + 1).'. '.$question->moduleQuestion->text }} </h5>
                @foreach($question->moduleQuestion->answers as $answer)
                    <input type="checkbox" {{ $answer['correct'] ? 'checked="true"' : ''}}> {{ $answer['value'] }} <br>
                @endforeach
            @elseif($question->moduleQuestion->type == 'Gaps')
                <h5> {{ ($key2 + 1).'. '.str_replace('____', '____________', $question->moduleQuestion->text) }} </h5>
            @endif
        @endforeach
    @endforeach
    </body>
</html>
