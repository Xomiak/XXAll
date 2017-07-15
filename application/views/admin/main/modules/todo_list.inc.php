<?php
$todo = $this->modules->getTodoList(userdata('login'));
vd($todo);
?>
<div class="col-md-6">
    <div class="panel panel-default" data-widget=''>
        <div class="panel-heading">
            <h2>Мои пометки</h2>
            <div class="panel-ctrls button-icon-bg"
                 data-actions-container=""
                 data-action-collapse='{"target": ".panel-body"}'
                 data-action-expand=''
                 data-action-colorpicker=''
                 data-action-edit=''
                 data-action-close=''
            >
            </div>
        </div>
        <div class="panel-editbox" data-widget-controls=""></div>
        <div class="panel-body panel-no-padding panel-todo">
            <ul class="connectedSortable" id="sortable-todo">
                <li class="">
	                            <span class="drag-todo">
	                                <div class="checkbox-inline icheck"><input type="checkbox"></div>
	                            </span>
                    <p class="todo-description">
                        Send project demo files to client
                    </p>

                </li>
                <li class="">
	                            <span class="drag-todo">
	                                <div class="checkbox-inline icheck"><input type="checkbox"></div>
	                            </span>
                    <p class="todo-description">
                        Sketch wireframes for new project and send it to client as soon as
                        possible
                    </p>

                </li>
                <li class="">
	                            <span class="drag-todo">
	                                <div class="checkbox-inline icheck"><input type="checkbox"></div>
	                            </span>
                    <p class="todo-description">
                        Buy some milk
                    </p>

                </li>
                <li class="">
	                            <span class="drag-todo">
	                                <div class="checkbox-inline icheck"><input type="checkbox"></div>
	                            </span>
                    <p class="todo-description">
                        Prepare documentation for completed project
                    </p>

                </li>
                <li class="">
	                            <span class="drag-todo">
	                                <div class="checkbox-inline icheck"><input type="checkbox"></div>
	                            </span>
                    <p class="todo-description">
                        Buy some drinks
                    </p>

                </li>
                <li class="">
	                            <span class="drag-todo">
	                                <div class="checkbox-inline icheck"><input type="checkbox"></div>
	                            </span>
                    <p class="todo-description">
                        Prepare presentation slides
                    </p>

                </li>
                <li class="">
	                            <span class="drag-todo">
	                                <div class="checkbox-inline icheck"><input type="checkbox"></div>
	                            </span>
                    <p class="todo-description">
                        Meeting with the development team
                    </p>

                </li>

            </ul>
            <span class="todo-header"></span>
            <ul class="todo-completed connectedSortable" id="completed-todo">

                <li class="">
	                            <span class="drag-todo">
	                                <div class="checkbox-inline icheck"><input type="checkbox" checked></div>
	                                <span class="drag-image"></span>
	                            </span>
                    <p class="todo-description">
                        Assign todo to designers
                    </p>

                </li>
                <li class="">
	                            <span class="drag-todo">
	                                <div class="checkbox-inline icheck"><input type="checkbox" checked></div>
	                                <span class="drag-image"></span>
	                            </span>
                    <p class="todo-description">
                        Backend bug fixes
                    </p>

                </li>
                <li class="">
	                            <span class="drag-todo">
	                                <div class="checkbox-inline icheck"><input type="checkbox" checked></div>
	                                <span class="drag-image"></span>
	                            </span>
                    <p class="todo-description">
                        Set up a meeting with new client
                    </p>

                </li>

            </ul>
            <div class="todo-footer clearfix">
                <a href="#" class="btn btn-sm btn-success"><i
                        class="visible-xs fa fa-plus"></i> <span
                        class="hidden-xs">New</span></a>
                <a href="#" class="btn btn-sm btn-default"><i
                        class="visible-xs fa fa-check"></i> <span class="hidden-xs">Mark All Done</span></a>
                <a href="app-todo.html" class="btn-link btn-sm pull-right"
                   style="padding-right: 0">Go to todo page</a>
            </div>
        </div>
    </div>
</div>