// Send Text
$payloadText = [
    'sessionId' => appSet('WHATSAPP_SESSION_ID'),
    'type'      => 'text',
    'category'  => 'parent-notification',
    'name'      => 'Ria Budi',
    'jid'       => '6281263280610@s.whatsapp.net',
    'text'      => 'Hello, this is a test from Laravel.'
];
return sendText($payloadText);



// Send Media Image
$payloadImage = [
    'sessionId' => appSet('WHATSAPP_SESSION_ID'),
    'type'      => 'image', // video, audio, document
    'category'  => 'parent-notification',
    'name'      => 'Ria Budi',
    'jid'       => '6281263280610@s.whatsapp.net',
    'media_url' => 'https://ruhulislam.com/wp-content/uploads/2023/06/riab-logo-text-1.png',
    'media_mime'=> 'image/png',
    "media" => [
                "image" => [
                    "url" => "https://ruhulislam.com/wp-content/uploads/2023/06/riab-logo-text-1.png" 
                ]
            ], 
    "caption" => "Berikut laporan dalam bentuk PDF" 
];
return sendMedia($payloadImage);


// Send Media Document
$payloadDocument = [
    'sessionId' => appSet('WHATSAPP_SESSION_ID'),
    'type'      => 'image', // video, audio, document
    'category'  => 'parent-notification',
    'name'      => 'Ria Budi',
    'jid'       => '6281263280610@s.whatsapp.net',
    'media_url' => 'https://gbihr-org.webpkgcache.com/doc/-/s/gbihr.org/images/docs/test.pdf',
    'media_mime'=> 'application/pdf',
    "media" => [
                "document" => [
                    "url" => "https://gbihr-org.webpkgcache.com/doc/-/s/gbihr.org/images/docs/test.pdf" 
                ],
                "mimetype" => "application/pdf",
                "fileName" => "file-laporan.pdf"
            ], 
    "caption" => "Berikut laporan dalam bentuk PDF" 
];
return sendMedia($payloadDocument);