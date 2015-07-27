$(function(){
    if( $.support.leadingWhitespace )
    {
        function getFileSize(obj)
        {
            if( obj.files[0]!=null && 'number'==typeof(obj.files[0].size))
                return obj.files[0].size;
            else
                return 0;
        }

        function getFileinfo(obj)
        {
            var arr = [], v;
            if( obj.files[0]!=null && 'number'==typeof(obj.files[0].size))
            {
                for(var n in obj.files[0] )
                {
                    v = obj.files[0].n;
                    arr.push(n+' : '+v);
                }

                arr.push('obj.files[0].webkitRelativePath : '+obj.files[0].webkitRelativePath );
                arr.push('obj.files[0].lastModifiedDate : '+obj.files[0].lastModifiedDate );
                arr.push('obj.files[0].name : '+obj.files[0].name );
                arr.push('obj.files[0].type : '+obj.files[0].type );
                arr.push('obj.files[0].size : '+obj.files[0].size );
                arr.push('obj.files[0].slice : '+obj.files[0].slice );
            }
            return arr.join('<br>');
        }

        function getFormate(bytes)
        {
            if( bytes<1024 )
                return bytes + ' bytes';
            else if( bytes<(1024*1024) )
                return bytes + ' bytes' + '(' + (bytes/1024).toFixed(2) + ' kb)';
            else if( bytes<(1024*1024*1024) )
                return bytes + ' bytes' + '(' + (bytes/(1024*1024)).toFixed(2) + ' MB)';
            else
                return bytes + ' bytes' + '(' + (bytes/(1024*1024*1024)).toFixed(2) + ' GB)';
        }

        function getTotalSize()
        {
            var totalsize = 0;
            $('.fileupload').each(function(){ totalsize += getFileSize(this); });
            $('#totalsize').html(getFormate(totalsize));
            totalsize = null;
        }

        function getInfo(obj)
        {
            var arr = [], v;
            for(var n in obj )
            {
                v = obj.n;
                arr.push(n+' : '+v);
            }
            return arr.sort().join('<br>');
        }

        $('.fileupload').change(function(){
            $(this).siblings('div').find('span').html(getFormate(getFileSize(this)));
            getTotalSize();
            $('#fileinfo1').html(getFileinfo(this));
            $('#fileinfo2').html(getInfo(this));
            $('#fileinfo3').html(getInfo($(this)));
        }).change();
    }
    else
    {
        /*
        var fileobj = ['Browser do not support'], v, count=0;
        for(var n in this )
        {
            v = $('#filesize').n;
            fileobj.push('{" '+n+'" : "'+v+'"}');
            count++;
        }
        $('#err_msg').html(fileobj.join('<br>'));
        fileobj = null;// 釋放IE記憶體
        */
        $('.fileupload').each(function(){
            $(this).siblings('div').find('span').html('Browser do not support');
        });
    }
});