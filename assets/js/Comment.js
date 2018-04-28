class Comment {
    // Constructor
    constructor(id, taskId, userId, username, name, comment, reference, dateCreation, dateModification, hascomments) {
        this.id = id || null;
        this.taskId = taskId || null;
        this.userId= userId || null;
        this.username= username || '';
        this.name= name || '';
        this.comment= comment || '';
        this.reference= reference || '';
        this.dateCreation= dateCreation || null;
        this.dateModification= dateModification || null;
        this.hasComments= hascomments || false;
    }
    
    //Getter
    get LoadbyTask() {
        $.ajax({
            type: "POST",
            url: "class/Comment.php",
            data: { 
                action: "LoadbyTask",
                taskId: this.taskId
            }
        })
        .done(function( e ) {
            ShowComments(e);
        })    
        .fail(function (e) {
            showError(e);
        });
    }  

    get Load() {
        $.ajax({
            type: "POST",
            url: "class/Comment.php",
            data: { 
                action: "Load",
                id: this.id
            }
        })
        .done(function( e ) {
            var data= JSON.parse(e)[0];
            //
        })    
        .fail(function (e) {
            showError(e);
        });
    }

    get Save() {
        $('#btnSaveComment').attr("disabled", "disabled");
        var miAccion= this.id==null ? 'Insert' : 'Update';      
        this.comment= $('#newComment').val();
        this.comment = this.comment.replace(/\n/g,"<br>");
        this.comment = this.comment.replace(/\r/g,"<br>");
        this.comment = this.comment.replace(/\t/g,"<br>");
        this.comment = this.comment.replace(/"/g,"'");
        //
        $.ajax({
            type: "POST",
            url: "class/Comment.php",
            data: { 
                action: miAccion,
                obj: JSON.stringify(this)
            }
        })
        .done(function() {
            ReloadComments();
        })    
        .fail(function (e) {
            showError(e);
        })
        .always(function(){
            $('#newComment').val('');
            setTimeout('$("#btnSaveComment").removeAttr("disabled")', 1500);
            comment= new Comment();
        });
    }

    get Delete() {
        $.ajax({
            type: "POST",
            url: "class/Comment.php",
            data: { 
                action: 'Delete',                
                obj:  JSON.stringify(this)
            }            
        })
        .done(function() {
            swal({
                //position: 'top-end',
                type: 'success',
                title: 'Eliminado!',
                showConfirmButton: false,
                timer: 1500
            });
        })    
        .fail(function (e) {
            showError(e);
        })
        .always(function(){
            comment= new Comment();
            ReloadComments();
        });
    }
}

//Metodos

let comment = new Comment();

$(document).ready(function(){

});

function ShowComments(e){
    $('#commentBox').html('');
    var data= JSON.parse(e);    
    //var lastI= data.lenght - 1;
    $.each(data, function (i, item) {
        $("#hascomments").css("display", "inline");
        var avatarLetter = item.name.split(' ');
        avatarLetter= avatarLetter[0].substring(0,1) + avatarLetter[1].substring(0,1);
        var modificacion = Date(item.date_creation*1000);
        $('#commentBox').append(`
            <div class="comment" id="comment${item.id}" value= ${item.id} > 
                <div class="avatar avatar-left"> 
                    <div class="avatar-letter" style="background-color: rgb(154, 108, 224)" title="${item.name}">${avatarLetter}</div> 
                </div>
                <div class="comment-title"> 
                    <strong class="comment-username"> ${item.name} </strong> 
                    <small class="comment-date">Creado en: ${moment(item.date_creation*1000).format('MMMM Do YYYY, h:mm')}</small>
                    <small class="comment-date">Actualizado: ${moment(item.date_modification*1000).fromNow() }</small>
                </div>

                <div class="comment-actions">
                    <div class="dropdown">
                        <a href="#" class="dropdown-menu dropdown-menu-link-icon"><i class="fa fa-cog"></i><i class="glyphicon glyphicon-cog"></i></a>
                        <ul>
                            <!-- <li>
                                <a href="/kanboard/?controller=CommentController&amp;action=edit&amp;task_id=5071&amp;project_id=20&amp;comment_id=83" class="js-modal-medium" title=""><i class="fa fa-edit fa-fw js-modal-medium" aria-hidden="true"></i>Modificar</a>
                            </li> -->
                            <li id="delete${item.id}" value="${item.id}" >
                                <a class="js-modal-confirm" ><i class="glyphicon glyphicon-trash" aria-hidden="true"></i>Suprimir</a>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <div class="comment-content"> <div class="markdown"> <p> ${item.comment} </p> </div>
            </div>
        `);        
        //event handler
        $(`#delete${item.id}`).click(function(e){
            comment.id= $(this).attr('value');
            DeleteEventHandler();
        });
    })
}

function DeleteEventHandler(){
    swal({
        title: 'Eliminar?',
        text: "Esta acción es irreversible!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, eliminar!',
        cancelButtonText: 'No, cancelar!',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger'
    }).then((result) => {
        if (result.value) {
            comment.Delete;
        }
    })
};

function ReloadComments(){
    comment.taskId= id; // task_id
    comment.LoadbyTask;
};