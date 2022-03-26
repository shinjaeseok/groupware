@extends('layouts.default')

@section('head')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endsection


@section('content')

    <div class="row">
        <div class="col-xl-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h3>프로젝트</h3>
                </div>
                <div class="ibox-content">

                    <div class="project-list">

                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <td class="project-status">
                                    <span class="label label-primary">Active</span>
                                </td>
                                <td class="project-title">
                                    <a href="project_detail.html">Contract with Zender Company</a>
                                    <br/>
                                    <small>Created 14.08.2014</small>
                                </td>
                                <td class="project-completion">
                                    <small>Completion with: 48%</small>
                                    <div class="progress progress-mini">
                                        <div style="width: 48%;" class="progress-bar"></div>
                                    </div>
                                </td>
                                <td class="project-people">
                                    <a href=""><img alt="image" class="rounded-circle" src="img/a3.jpg"></a>
                                    <a href=""><img alt="image" class="rounded-circle" src="img/a1.jpg"></a>
                                    <a href=""><img alt="image" class="rounded-circle" src="img/a2.jpg"></a>
                                    <a href=""><img alt="image" class="rounded-circle" src="img/a4.jpg"></a>
                                    <a href=""><img alt="image" class="rounded-circle" src="img/a5.jpg"></a>
                                </td>
                                <td class="project-actions">
                                    <a href="#" class="btn btn-white btn-sm"><i class="fa fa-folder"></i> View </a>
                                    <a href="#" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> Edit </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="project-status">
                                    <span class="label label-primary">Active</span>
                                </td>
                                <td class="project-title">
                                    <a href="project_detail.html">There are many variations of passages</a>
                                    <br/>
                                    <small>Created 11.08.2014</small>
                                </td>
                                <td class="project-completion">
                                    <small>Completion with: 28%</small>
                                    <div class="progress progress-mini">
                                        <div style="width: 28%;" class="progress-bar"></div>
                                    </div>
                                </td>
                                <td class="project-people">
                                    <a href=""><img alt="image" class="rounded-circle" src="img/a7.jpg"></a>
                                    <a href=""><img alt="image" class="rounded-circle" src="img/a6.jpg"></a>
                                    <a href=""><img alt="image" class="rounded-circle" src="img/a3.jpg"></a>
                                </td>
                                <td class="project-actions">
                                    <a href="#" class="btn btn-white btn-sm"><i class="fa fa-folder"></i> View </a>
                                    <a href="#" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> Edit </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="project-status">
                                    <span class="label label-default">Unactive</span>
                                </td>
                                <td class="project-title">
                                    <a href="project_detail.html">Many desktop publishing packages and web</a>
                                    <br/>
                                    <small>Created 10.08.2014</small>
                                </td>
                                <td class="project-completion">
                                    <small>Completion with: 8%</small>
                                    <div class="progress progress-mini">
                                        <div style="width: 8%;" class="progress-bar"></div>
                                    </div>
                                </td>
                                <td class="project-people">
                                    <a href=""><img alt="image" class="rounded-circle" src="img/a5.jpg"></a>
                                    <a href=""><img alt="image" class="rounded-circle" src="img/a3.jpg"></a>
                                </td>
                                <td class="project-actions">
                                    <a href="#" class="btn btn-white btn-sm"><i class="fa fa-folder"></i> View </a>
                                    <a href="#" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> Edit </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="project-status">
                                    <span class="label label-primary">Active</span>
                                </td>
                                <td class="project-title">
                                    <a href="project_detail.html">Letraset sheets containing</a>
                                    <br/>
                                    <small>Created 22.07.2014</small>
                                </td>
                                <td class="project-completion">
                                    <small>Completion with: 83%</small>
                                    <div class="progress progress-mini">
                                        <div style="width: 83%;" class="progress-bar"></div>
                                    </div>
                                </td>
                                <td class="project-people">
                                    <a href=""><img alt="image" class="rounded-circle" src="img/a2.jpg"></a>
                                    <a href=""><img alt="image" class="rounded-circle" src="img/a3.jpg"></a>
                                    <a href=""><img alt="image" class="rounded-circle" src="img/a1.jpg"></a>
                                    <a href=""><img alt="image" class="rounded-circle" src="img/a7.jpg"></a>
                                </td>
                                <td class="project-actions">
                                    <a href="#" class="btn btn-white btn-sm"><i class="fa fa-folder"></i> View </a>
                                    <a href="#" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> Edit </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="project-status">
                                    <span class="label label-primary">Active</span>
                                </td>
                                <td class="project-title">
                                    <a href="project_detail.html">Contrary to popular belief</a>
                                    <br/>
                                    <small>Created 14.07.2014</small>
                                </td>
                                <td class="project-completion">
                                    <small>Completion with: 97%</small>
                                    <div class="progress progress-mini">
                                        <div style="width: 97%;" class="progress-bar"></div>
                                    </div>
                                </td>
                                <td class="project-people">
                                    <a href=""><img alt="image" class="rounded-circle" src="img/a4.jpg"></a>
                                </td>
                                <td class="project-actions">
                                    <a href="#" class="btn btn-white btn-sm"><i class="fa fa-folder"></i> View </a>
                                    <a href="#" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> Edit </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="project-status">
                                    <span class="label label-primary">Active</span>
                                </td>
                                <td class="project-title">
                                    <a href="project_detail.html">Contract with Zender Company</a>
                                    <br/>
                                    <small>Created 14.08.2014</small>
                                </td>
                                <td class="project-completion">
                                    <small>Completion with: 48%</small>
                                    <div class="progress progress-mini">
                                        <div style="width: 48%;" class="progress-bar"></div>
                                    </div>
                                </td>
                                <td class="project-people">
                                    <a href=""><img alt="image" class="rounded-circle" src="img/a1.jpg"></a>
                                    <a href=""><img alt="image" class="rounded-circle" src="img/a2.jpg"></a>
                                    <a href=""><img alt="image" class="rounded-circle" src="img/a4.jpg"></a>
                                    <a href=""><img alt="image" class="rounded-circle" src="img/a5.jpg"></a>
                                </td>
                                <td class="project-actions">
                                    <a href="#" class="btn btn-white btn-sm"><i class="fa fa-folder"></i> View </a>
                                    <a href="#" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> Edit </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="project-status">
                                    <span class="label label-primary">Active</span>
                                </td>
                                <td class="project-title">
                                    <a href="project_detail.html">There are many variations of passages</a>
                                    <br/>
                                    <small>Created 11.08.2014</small>
                                </td>
                                <td class="project-completion">
                                    <small>Completion with: 28%</small>
                                    <div class="progress progress-mini">
                                        <div style="width: 28%;" class="progress-bar"></div>
                                    </div>
                                </td>
                                <td class="project-people">
                                    <a href=""><img alt="image" class="rounded-circle" src="img/a7.jpg"></a>
                                    <a href=""><img alt="image" class="rounded-circle" src="img/a6.jpg"></a>
                                    <a href=""><img alt="image" class="rounded-circle" src="img/a3.jpg"></a>
                                </td>
                                <td class="project-actions">
                                    <a href="#" class="btn btn-white btn-sm"><i class="fa fa-folder"></i> View </a>
                                    <a href="#" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> Edit </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="project-status">
                                    <span class="label label-default">Unactive</span>
                                </td>
                                <td class="project-title">
                                    <a href="project_detail.html">Many desktop publishing packages and web</a>
                                    <br/>
                                    <small>Created 10.08.2014</small>
                                </td>
                                <td class="project-completion">
                                    <small>Completion with: 8%</small>
                                    <div class="progress progress-mini">
                                        <div style="width: 8%;" class="progress-bar"></div>
                                    </div>
                                </td>
                                <td class="project-people">
                                    <a href=""><img alt="image" class="rounded-circle" src="img/a5.jpg"></a>
                                    <a href=""><img alt="image" class="rounded-circle" src="img/a3.jpg"></a>
                                </td>
                                <td class="project-actions">
                                    <a href="#" class="btn btn-white btn-sm"><i class="fa fa-folder"></i> View </a>
                                    <a href="#" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> Edit </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="project-status">
                                    <span class="label label-primary">Active</span>
                                </td>
                                <td class="project-title">
                                    <a href="project_detail.html">Letraset sheets containing</a>
                                    <br/>
                                    <small>Created 22.07.2014</small>
                                </td>
                                <td class="project-completion">
                                    <small>Completion with: 83%</small>
                                    <div class="progress progress-mini">
                                        <div style="width: 83%;" class="progress-bar"></div>
                                    </div>
                                </td>
                                <td class="project-people">
                                    <a href=""><img alt="image" class="rounded-circle" src="img/a2.jpg"></a>
                                    <a href=""><img alt="image" class="rounded-circle" src="img/a3.jpg"></a>
                                    <a href=""><img alt="image" class="rounded-circle" src="img/a1.jpg"></a>
                                </td>
                                <td class="project-actions">
                                    <a href="#" class="btn btn-white btn-sm"><i class="fa fa-folder"></i> View </a>
                                    <a href="#" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> Edit </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="project-status">
                                    <span class="label label-primary">Active</span>
                                </td>
                                <td class="project-title">
                                    <a href="project_detail.html">Contrary to popular belief</a>
                                    <br/>
                                    <small>Created 14.07.2014</small>
                                </td>
                                <td class="project-completion">
                                    <small>Completion with: 97%</small>
                                    <div class="progress progress-mini">
                                        <div style="width: 97%;" class="progress-bar"></div>
                                    </div>
                                </td>
                                <td class="project-people">
                                    <a href=""><img alt="image" class="rounded-circle" src="img/a4.jpg"></a>
                                </td>
                                <td class="project-actions">
                                    <a href="#" class="btn btn-white btn-sm"><i class="fa fa-folder"></i> View </a>
                                    <a href="#" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> Edit </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="project-status">
                                    <span class="label label-primary">Active</span>
                                </td>
                                <td class="project-title">
                                    <a href="project_detail.html">There are many variations of passages</a>
                                    <br/>
                                    <small>Created 11.08.2014</small>
                                </td>
                                <td class="project-completion">
                                    <small>Completion with: 28%</small>
                                    <div class="progress progress-mini">
                                        <div style="width: 28%;" class="progress-bar"></div>
                                    </div>
                                </td>
                                <td class="project-people">
                                    <a href=""><img alt="image" class="rounded-circle" src="img/a7.jpg"></a>
                                    <a href=""><img alt="image" class="rounded-circle" src="img/a6.jpg"></a>
                                    <a href=""><img alt="image" class="rounded-circle" src="img/a3.jpg"></a>
                                </td>
                                <td class="project-actions">
                                    <a href="#" class="btn btn-white btn-sm"><i class="fa fa-folder"></i> View </a>
                                    <a href="#" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> Edit </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>


                        <div class="row">
                            <div class="col-xl-12 text-right">
                                <button type="button" class="btn btn-primary btn-sm" id="btn_create">등록</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
    <div class="modal fade" id="modal_input" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">
                        업무일지 등록
                    </h4>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                </div>

                <div class="modal-body">
                    <div class="row mb-1">
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label class="form-label" for="title">제목</label>
                                <input form="form_modal" type="text" class="form-control" id="title" name="title" value="{{date("Y-m-d")}} 일일업무일지">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label class="form-label" for="contents">내용</label>
                                <textarea form="form_modal" id="contents" name="contents" class="form-control summernote" rows="15"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button form="form_modal" type="button" class="btn btn-secondary" data-dismiss="modal">닫기</button>
                    <button form="form_modal" type="button" class="btn btn-primary" id="btn_save">저장</button>
                </div>
            </div>
        </div>
    </div>

    <form id="form_modal" name="form_modal">
        <input type="hidden" id="modal_id" name="modal_id">
    </form>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/lang/summernote-ko-KR.js"></script>
    @include('task.dailyTask_js')
@endsection
