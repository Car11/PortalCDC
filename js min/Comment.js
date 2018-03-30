class Comment{constructor(a,b,c,d,f,g,h,j,k,l){this.id=a||null,this.taskId=b||null,this.userId=c||null,this.username=d||'',this.name=f||'',this.comment=g||'',this.reference=h||'',this.dateCreation=j||null,this.dateModification=k||null,this.hasComments=l||!1}get LoadbyTask(){$.ajax({type:'POST',url:'class/Comment.php',data:{action:'LoadbyTask',taskId:this.taskId}}).done(function(a){ShowComments(a)}).fail(function(a){showError(a)})}get Load(){$.ajax({type:'POST',url:'class/Comment.php',data:{action:'Load',id:this.id}}).done(function(a){JSON.parse(a)[0]}).fail(function(a){showError(a)})}get Save(){$('#btnSaveComment').attr('disabled','disabled');var a=null==this.id?'Insert':'Update';this.comment=$('#newComment').val(),this.comment=this.comment.replace(/\n/g,'<br>'),this.comment=this.comment.replace(/\r/g,'<br>'),$.ajax({type:'POST',url:'class/Comment.php',data:{action:a,obj:JSON.stringify(this)}}).done(function(){ReloadComments()}).fail(function(b){showError(b)}).always(function(){$('#newComment').val(''),setTimeout('$("#btnSaveComment").removeAttr("disabled")',1500),comment=new Comment})}get Delete(){$.ajax({type:'POST',url:'class/Comment.php',data:{action:'Delete',obj:JSON.stringify(this)}}).done(function(){swal({type:'success',title:'Eliminado!',showConfirmButton:!1,timer:1500})}).fail(function(a){showError(a)}).always(function(){comment=new Comment,ReloadComments()})}}let comment=new Comment;$(document).ready(function(){});function ShowComments(a){$('#commentBox').html('');var b=JSON.parse(a);$.each(b,function(c,d){$('#hascomments').css('display','inline');var f=d.name.split(' ');f=f[0].substring(0,1)+f[1].substring(0,1);Date(1e3*d.date_creation);$('#commentBox').append(`
            <div class="comment" id="comment${d.id}" value= ${d.id} > 
                <div class="avatar avatar-left"> 
                    <div class="avatar-letter" style="background-color: rgb(154, 108, 224)" title="${d.name}">${f}</div> 
                </div>
                <div class="comment-title"> 
                    <strong class="comment-username"> ${d.name} </strong> 
                    <small class="comment-date">Creado en: ${moment(1e3*d.date_creation).format('MMMM Do YYYY, h:mm')}</small>
                    <small class="comment-date">Actualizado: ${moment(1e3*d.date_modification).fromNow()}</small>
                </div>

                <div class="comment-actions">
                    <div class="dropdown">
                        <a href="#" class="dropdown-menu dropdown-menu-link-icon"><i class="fa fa-cog"></i><i class="glyphicon glyphicon-cog"></i></a>
                        <ul>
                            <!-- <li>
                                <a href="/kanboard/?controller=CommentController&amp;action=edit&amp;task_id=5071&amp;project_id=20&amp;comment_id=83" class="js-modal-medium" title=""><i class="fa fa-edit fa-fw js-modal-medium" aria-hidden="true"></i>Modificar</a>
                            </li> -->
                            <li id="delete${d.id}" value="${d.id}" >
                                <a class="js-modal-confirm" ><i class="glyphicon glyphicon-trash" aria-hidden="true"></i>Suprimir</a>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <div class="comment-content"> <div class="markdown"> <p> ${d.comment} </p> </div>
            </div>
        `),$(`#delete${d.id}`).click(function(){comment.id=$(this).attr('value'),DeleteEventHandler()})})}function DeleteEventHandler(){swal({title:'Eliminar?',text:'Esta acci\xF3n es irreversible!',type:'warning',showCancelButton:!0,confirmButtonColor:'#3085d6',cancelButtonColor:'#d33',confirmButtonText:'Si, eliminar!',cancelButtonText:'No, cancelar!',confirmButtonClass:'btn btn-success',cancelButtonClass:'btn btn-danger'}).then(a=>{a.value&&comment.Delete})}function ReloadComments(){comment.taskId=id,comment.LoadbyTask}