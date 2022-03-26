<script>
    $('#tree').jstree({
        'core' : {

            "themes" : {
                "dots" : false
            },
            'data' : {
                'url' : function (node) {
                    return node.id === '#' ?
                        '/api/approval_department_tree_root' :
                        '/api/approval_department_tree_children';
                },
                'data' : function (node) {
                    return { 'id' : node.id };
                }
            }
        }});

    $('#tree').on('activate_node.jstree', function (e, data) {
        if (data == undefined || data.node == undefined || data.node.id == undefined)
            return;

        $("#search_key").val("").trigger("change");
        $("#search_value").val("");

        document_view(data.node.id);
    });

    function document_view(document_id) {

        $.ajax({
            type: "get",
            data: { "document_id": document_id},
            url: "/approval_document_preview",
            dataType: "json",
            cache: false,
            async: false,
        }).done(function(result) {
            $("#contents").html(result.content);
        });
    }
</script>

<script type="text/javascript">
    $(document).ready(function(){
        DecoupledEditor
            .create( document.querySelector( '.document-editor__editable' ), {
            } )
            .then( editor => {
                const toolbarContainer = document.querySelector( '.document-editor__toolbar' );

                toolbarContainer.appendChild( editor.ui.view.toolbar.element );

                window.editor = editor;
            } )
            .catch( err => {
                console.error( err );
            } );

        $('input[type="file"]').change(function(e){
            let fileName
            e.target.files[0] ? fileName = e.target.files[0].name : fileName = '';
            $(e.target).parent('div').find('label').html(fileName);
        });
    })
</script>
<script>
</script>
