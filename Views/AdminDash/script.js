function send_data(form)
{
    var ajax = XMLHttprequest();

    ajax.addEvenListner('progress',function(){});
    ajax.upload.addEvenListner('progress',function(e){
        let percent = Math.round((e.loaded / e.total) * 100);
        
    });
    ajax.open('post','ajax.php', true);
    ajax.send();
}