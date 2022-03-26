@extends('layouts.default')

@section('head')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endsection


@section('content')

    <div class="row">
        <div class="col-xl-12">
            <div class="ibox">
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="m-b-md">
                                <a href="#" class="btn btn-white btn-xs float-right">Edit project</a>

                                <h2>Contract with Zender Company</h2>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <dl class="row mb-0">
                                <div class="col-sm-4 text-sm-right">
                                    <dt>Status:</dt>
                                </div>
                                <div class="col-sm-8 text-sm-left">
                                    <dd class="mb-1"><span class="label label-primary">Active</span></dd>
                                </div>
                            </dl>
                            <dl class="row mb-0">
                                <div class="col-sm-4 text-sm-right">
                                    <dt>Created by:</dt>
                                </div>
                                <div class="col-sm-8 text-sm-left">
                                    <dd class="mb-1">Alex Smith</dd>
                                </div>
                            </dl>
                            <dl class="row mb-0">
                                <div class="col-sm-4 text-sm-right">
                                    <dt>Messages:</dt>
                                </div>
                                <div class="col-sm-8 text-sm-left">
                                    <dd class="mb-1"> 162</dd>
                                </div>
                            </dl>
                            <dl class="row mb-0">
                                <div class="col-sm-4 text-sm-right">
                                    <dt>Client:</dt>
                                </div>
                                <div class="col-sm-8 text-sm-left">
                                    <dd class="mb-1"><a href="#" class="text-navy"> Zender Company</a></dd>
                                </div>
                            </dl>
                            <dl class="row mb-0">
                                <div class="col-sm-4 text-sm-right">
                                    <dt>Version:</dt>
                                </div>
                                <div class="col-sm-8 text-sm-left">
                                    <dd class="mb-1"> v1.4.2</dd>
                                </div>
                            </dl>

                        </div>
                        <div class="col-lg-6" id="cluster_info">

                            <dl class="row mb-0">
                                <div class="col-sm-4 text-sm-right">
                                    <dt>Last Updated:</dt>
                                </div>
                                <div class="col-sm-8 text-sm-left">
                                    <dd class="mb-1">16.08.2014 12:15:57</dd>
                                </div>
                            </dl>
                            <dl class="row mb-0">
                                <div class="col-sm-4 text-sm-right">
                                    <dt>Created:</dt>
                                </div>
                                <div class="col-sm-8 text-sm-left">
                                    <dd class="mb-1"> 10.07.2014 23:36:57</dd>
                                </div>
                            </dl>
                            <dl class="row mb-0">
                                <div class="col-sm-4 text-sm-right">
                                    <dt>Participants:</dt>
                                </div>
                                <div class="col-sm-8 text-sm-left">
                                    <dd class="project-people mb-1">
                                        <a href=""><img alt="image" class="rounded-circle" src="img/a3.jpg"></a>
                                        <a href=""><img alt="image" class="rounded-circle" src="img/a1.jpg"></a>
                                        <a href=""><img alt="image" class="rounded-circle" src="img/a2.jpg"></a>
                                        <a href=""><img alt="image" class="rounded-circle" src="img/a4.jpg"></a>
                                        <a href=""><img alt="image" class="rounded-circle" src="img/a5.jpg"></a>
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <dl class="row mb-0">
                                <div class="col-sm-2 text-sm-right">
                                    <dt>Completed:</dt>
                                </div>
                                <div class="col-sm-10 text-sm-left">
                                    <dd>
                                        <div class="progress m-b-1">
                                            <div style="width: 60%;" class="progress-bar progress-bar-striped progress-bar-animated"></div>
                                        </div>
                                        <small>Project completed in <strong>60%</strong>. Remaining close the project, sign a contract and invoice.</small>
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                    <div class="row m-t-sm">
                        <div class="col-lg-12">
                            <div class="panel blank-panel">
                                <div class="panel-heading">
                                    <div class="panel-options">
                                        <ul class="nav nav-tabs">
                                            <li><a class="nav-link active" href="#tab-1" data-toggle="tab">Users messages</a></li>
                                            <li><a class="nav-link" href="#tab-2" data-toggle="tab">Last activity</a></li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="panel-body">

                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab-1">
                                            <div class="feed-activity-list">
                                                <div class="feed-element">
                                                    <a href="#" class="float-left">
                                                        <img alt="image" class="rounded-circle" src="img/a2.jpg">
                                                    </a>

                                                    <div class="media-body ">
                                                        <small class="float-right">2h ago</small>
                                                        <strong>Mark Johnson</strong> posted message on <strong>Monica Smith</strong> site. <br>
                                                        <small class="text-muted">Today 2:10 pm - 12.06.2014</small>
                                                        <div class="well">
                                                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.
                                                            Over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="feed-element">
                                                    <a href="#" class="float-left">
                                                        <img alt="image" class="rounded-circle" src="img/a3.jpg">
                                                    </a>

                                                    <div class="media-body ">
                                                        <small class="float-right">2h ago</small>
                                                        <strong>Janet Rosowski</strong> add 1 photo on <strong>Monica Smith</strong>. <br>
                                                        <small class="text-muted">2 days ago at 8:30am</small>
                                                    </div>
                                                </div>
                                                <div class="feed-element">
                                                    <a href="#" class="float-left">
                                                        <img alt="image" class="rounded-circle" src="img/a4.jpg">
                                                    </a>

                                                    <div class="media-body ">
                                                        <small class="float-right text-navy">5h ago</small>
                                                        <strong>Chris Johnatan Overtunk</strong> started following <strong>Monica Smith</strong>. <br>
                                                        <small class="text-muted">Yesterday 1:21 pm - 11.06.2014</small>
                                                        <div class="actions">
                                                            <a href="" class="btn btn-xs btn-white"><i class="fa fa-thumbs-up"></i> Like </a>
                                                            <a href="" class="btn btn-xs btn-white"><i class="fa fa-heart"></i> Love</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="feed-element">
                                                    <a href="#" class="float-left">
                                                        <img alt="image" class="rounded-circle" src="img/a5.jpg">
                                                    </a>

                                                    <div class="media-body ">
                                                        <small class="float-right">2h ago</small>
                                                        <strong>Kim Smith</strong> posted message on <strong>Monica Smith</strong> site. <br>
                                                        <small class="text-muted">Yesterday 5:20 pm - 12.06.2014</small>
                                                        <div class="well">
                                                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.
                                                            Over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="feed-element">
                                                    <a href="#" class="float-left">
                                                        <img alt="image" class="rounded-circle" src="img/profile.jpg">
                                                    </a>

                                                    <div class="media-body ">
                                                        <small class="float-right">23h ago</small>
                                                        <strong>Monica Smith</strong> love <strong>Kim Smith</strong>. <br>
                                                        <small class="text-muted">2 days ago at 2:30 am - 11.06.2014</small>
                                                    </div>
                                                </div>
                                                <div class="feed-element">
                                                    <a href="#" class="float-left">
                                                        <img alt="image" class="rounded-circle" src="img/a7.jpg">
                                                    </a>

                                                    <div class="media-body ">
                                                        <small class="float-right">46h ago</small>
                                                        <strong>Mike Loreipsum</strong> started following <strong>Monica Smith</strong>. <br>
                                                        <small class="text-muted">3 days ago at 7:58 pm - 10.06.2014</small>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="tab-pane" id="tab-2">

                                            <table class="table table-striped">
                                                <thead>
                                                <tr>
                                                    <th>Status</th>
                                                    <th>Title</th>
                                                    <th>Start Time</th>
                                                    <th>End Time</th>
                                                    <th>Comments</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>
                                                        <span class="label label-primary"><i class="fa fa-check"></i> Completed</span>
                                                    </td>
                                                    <td>
                                                        Create project in webapp
                                                    </td>
                                                    <td>
                                                        12.07.2014 10:10:1
                                                    </td>
                                                    <td>
                                                        14.07.2014 10:16:36
                                                    </td>
                                                    <td>
                                                        <p class="small">
                                                            Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable.
                                                        </p>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td>
                                                        <span class="label label-primary"><i class="fa fa-check"></i> Accepted</span>
                                                    </td>
                                                    <td>
                                                        Various versions
                                                    </td>
                                                    <td>
                                                        12.07.2014 10:10:1
                                                    </td>
                                                    <td>
                                                        14.07.2014 10:16:36
                                                    </td>
                                                    <td>
                                                        <p class="small">
                                                            Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
                                                        </p>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td>
                                                        <span class="label label-primary"><i class="fa fa-check"></i> Sent</span>
                                                    </td>
                                                    <td>
                                                        There are many variations
                                                    </td>
                                                    <td>
                                                        12.07.2014 10:10:1
                                                    </td>
                                                    <td>
                                                        14.07.2014 10:16:36
                                                    </td>
                                                    <td>
                                                        <p class="small">
                                                            There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which
                                                        </p>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td>
                                                        <span class="label label-primary"><i class="fa fa-check"></i> Reported</span>
                                                    </td>
                                                    <td>
                                                        Latin words
                                                    </td>
                                                    <td>
                                                        12.07.2014 10:10:1
                                                    </td>
                                                    <td>
                                                        14.07.2014 10:16:36
                                                    </td>
                                                    <td>
                                                        <p class="small">
                                                            Latin words, combined with a handful of model sentence structures
                                                        </p>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td>
                                                        <span class="label label-primary"><i class="fa fa-check"></i> Accepted</span>
                                                    </td>
                                                    <td>
                                                        The generated Lorem
                                                    </td>
                                                    <td>
                                                        12.07.2014 10:10:1
                                                    </td>
                                                    <td>
                                                        14.07.2014 10:16:36
                                                    </td>
                                                    <td>
                                                        <p class="small">
                                                            The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.
                                                        </p>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td>
                                                        <span class="label label-primary"><i class="fa fa-check"></i> Sent</span>
                                                    </td>
                                                    <td>
                                                        The first line
                                                    </td>
                                                    <td>
                                                        12.07.2014 10:10:1
                                                    </td>
                                                    <td>
                                                        14.07.2014 10:16:36
                                                    </td>
                                                    <td>
                                                        <p class="small">
                                                            The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.
                                                        </p>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td>
                                                        <span class="label label-primary"><i class="fa fa-check"></i> Reported</span>
                                                    </td>
                                                    <td>
                                                        The standard chunk
                                                    </td>
                                                    <td>
                                                        12.07.2014 10:10:1
                                                    </td>
                                                    <td>
                                                        14.07.2014 10:16:36
                                                    </td>
                                                    <td>
                                                        <p class="small">
                                                            The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested.
                                                        </p>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td>
                                                        <span class="label label-primary"><i class="fa fa-check"></i> Completed</span>
                                                    </td>
                                                    <td>
                                                        Lorem Ipsum is that
                                                    </td>
                                                    <td>
                                                        12.07.2014 10:10:1
                                                    </td>
                                                    <td>
                                                        14.07.2014 10:16:36
                                                    </td>
                                                    <td>
                                                        <p class="small">
                                                            Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable.
                                                        </p>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td>
                                                        <span class="label label-primary"><i class="fa fa-check"></i> Sent</span>
                                                    </td>
                                                    <td>
                                                        Contrary to popular
                                                    </td>
                                                    <td>
                                                        12.07.2014 10:10:1
                                                    </td>
                                                    <td>
                                                        14.07.2014 10:16:36
                                                    </td>
                                                    <td>
                                                        <p class="small">
                                                            Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical
                                                        </p>
                                                    </td>

                                                </tr>

                                                </tbody>
                                            </table>

                                        </div>
                                    </div>

                                </div>

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
