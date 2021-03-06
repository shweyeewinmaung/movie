<?php

return [
    'ffmpeg' => [
   'binaries' => env('FFMPEG_BINARIES', 'C:\FFMPEG\ffmpeg.exe'),
     
      //'binaries' => env('FFMPEG_BINARIES', '/usr/bin/ffmpeg'),
        'threads'  => 12,
    ],

    'ffprobe' => [
     'binaries' => env('FFPROBE_BINARIES', 'C:\FFMPEG\ffprobe.exe'),
     // 'binaries' => env('FFPROBE_BINARIES', '/usr/bin/ffprobe'),
     
    ],

    'timeout' => 9600,

    'enable_logging' => true,

    'set_command_and_error_output_on_exception' => false,
];
