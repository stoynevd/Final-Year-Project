<html>
    <head>
        <title> Exam </title>
        <meta charset="utf-8">
    </head>
    <body>
    <h2 style="text-align: center;"> {{ $exam->name }} </h2>
    @foreach($exam->sections as $key => $section)
        <h4> Section #{{ $key + 1 }} </h4>
        @foreach($section->questions as $key2 => $question)
            <h5> Question #{{ ($key2 + 1) }} </h5>
            @if($question->moduleQuestion->type == 'Multiple')
                @foreach($question->moduleQuestion->answers as $answer)
                    @if($answer['correct'])
                        - {{ $answer['value'] }} <br>
                    @endif
                @endforeach
            @else
                No answers, Question Type: {{ $question->moduleQuestion->type }}
            @endif
        @endforeach
    @endforeach
    </body>
</html>
