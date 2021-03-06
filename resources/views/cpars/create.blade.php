@extends('layouts.super-admin')

@section('page-title') Create CPAR | eQMS @stop

@section('nav-audit-findings') active @stop

@section('page-content')
    <div class="page-content-wrap">

        <div class="page-title">
            <h2><span class="fa fa-pencil"></span> CORRECTIVE AND PREVENTIVE ACTION REPORT FORM</h2>
        </div>

        <div class="row">
            <div class="col-md-9">

                <form enctype="multipart/form-data" class="form-horizontal" action="/cpars" method="POST" role="form">
                    {{ csrf_field() }}
                    <div class="panel panel-default">
                        <div class="panel-body form-group-separated">
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Raised By</label>
                                <div class="col-md-9 col-xs-12">
                                    <input type="text" class="hidden" value="{{ request('user.first_name'). ' ' .request('user.last_name') }}" name="raised-by"/>
                                    <label class="form-control">{{ request('user.first_name'). ' ' .request('user.last_name') }}</label>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Department</label>
                                <div class="col-md-5 col-xs-16">
                                    <select name="department" class="form-control select" id="department-select">
                                        <option>Accounting</option>
                                        <option>Human Resource</option>
                                        <option>Information Technology</option>
                                        <option>Internal Audit</option>
                                        <option>Training</option>
                                        <option>Research and Development</option>
                                        <option>Quality Management Representative</option>
                                    </select>
                                    <span class="help-block" id="department-hint"></span>
                                </div>
                                <div class="col-md-4 col-xs-12 @if(session('branch')) has-error @endif">
                                    <select name="branch" class="form-control select">
                                        <option selected disabled>Branch</option>
                                        <option>Bacolod</option>
                                        <option>Cebu</option>
                                        <option>Davao</option>
                                        <option>Iloilo</option>
                                        <option>Makati</option>
                                    </select>
                                    @if(session('branch')) <span class="text text-danger"><strong>{{ session()->pull('branch') }}</strong></span> @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Severity Of Findings</label>
                                <div class="col-md-9 col-xs-12">
                                    <select class="form-control select" name="severity">
                                        <option>Observation</option>
                                        <option>Minor</option>
                                        <option>Major</option>
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Procedure/Process/Scope/Other References</label>
                                <div class="col-md-9 col-xs-12">
                                    <select class="form-control select" name="reference" id="reference" onchange="showLink()" data-live-search="true">
                                        @foreach($sections as $section)
                                            @foreach($section->documents as $document)
                                                <option id="{{ $document->id }}" value="{{ $document->id }}">{{ $document->title }}</option>
                                            @endforeach
                                        @endforeach
                                    </select> <br><br>
                                    <h6><span id="span-reference">External Link Will Show Here</span></h6>
                                    <input type="text" class="tagsinput" name="tags"  value="{{ old('tags') }}"/>
                                    @if($errors->first('tags')) @component('layouts.error') {{ $errors->first('tags') }} @endcomponent @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Source Of Non-Comformity</label>
                                <div class="col-md-9 col-xs-12">
                                    <select class="form-control select" name="source">
                                        <option>External</option>
                                        <option>Internal</option>
                                        <option>Operational Performance</option>
                                        <option>Customer Feedback</option>
                                        <option>Customer Complain</option>
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group @if($errors->first('other-source')) has-error @endif">
                                <label class="col-md-3 col-xs-5 control-label">Others: (Please specify)</label>
                                <div class="col-md-9 col-xs-7">
                                    <textarea class="form-control" rows="3" name="other-source">{{ old('other-source') }}</textarea>
                                    @if($errors->first('other-source')) @component('layouts.error') {{ $errors->first('other-source') }} @endcomponent @endif
                                </div>
                            </div>
                            <div class="form-group @if($errors->first('details')) has-error @endif">
                                <label class="col-md-3 col-xs-5 control-label">Details</label>
                                <div class="col-md-9 col-xs-7">
                                    <textarea class="form-control" rows="5" name="details">{{ old('details') }}</textarea>
                                    @if($errors->first('details')) @component('layouts.error') {{ $errors->first('details') }} @endcomponent @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Name</label>
                                <div class="col-md-9 col-xs-12">
                                    <input type="text" class="hidden" value="{{ request('user.first_name'). ' ' .request('user.last_name') }}" name="person-reporting"/>
                                    <label class="form-control">{{ request('user.first_name'). ' ' .request('user.last_name') }}</label>
                                    <span class="help-block">Person Reporting To Non-Conformity</span>
                                </div>
                            </div>
                            <div class="form-group @if($errors->first('person-responsible')) has-error @endif">
                                <label class="col-md-3 col-xs-12 control-label">Name</label>
                                <div class="col-md-9 col-xs-12">
                                    <input type="text" class="form-control" name="person-responsible" value="{{ old('person-responsible') }}"/>
                                    @if($errors->first('person-responsible')) @component('layouts.error') {{ $errors->first('person-responsible') }} @endcomponent
                                    @else <span class="help-block">Person Responsible For Taking The CPAR</span> @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-5 control-label">Correction</label>
                                <div class="col-md-9 col-xs-7">
                                    <textarea class="form-control" rows="4" name="correction" disabled="disabled"></textarea>
                                    <span class="help-block">Action To Eliminate The Detected Non-Conformity</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-5 control-label">Root Cause Analysis</label>
                                <div class="col-md-9 col-xs-7">
                                    <textarea class="form-control" rows="4" name="root-cause" disabled="disabled"></textarea>
                                    <span class="help-block">What Failed In The System To Allow This Non-Conformance To Occur?</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-5 control-label">Corrective/Preventive Action</label>
                                <div class="col-md-9 col-xs-7">
                                    <textarea class="form-control" rows="4" name="cp-action" disabled="disabled"></textarea>
                                    <span class="help-block">Specific Details Of Corrective Action Taken To Prevent Recurrence/Occurrence</span>
                                </div>
                            </div>
                            <div class="form-group @if($errors->first('proposed-date')) has-error @endif">
                                <label class="col-md-3 col-xs-12 control-label">Proposed Corrective Action Complete Date</label>
                                <div class="col-md-9 col-xs-12">
                                    <input type="text" class="form-control datepicker" name="proposed-date" value="{{ old('proposed-date') }}"/>
                                    @if($errors->first('proposed-date')) @component('layouts.error') {{ $errors->first('proposed-date') }} @endcomponent @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Corrective/Preventive Complete Date</label>
                                <div class="col-md-9 col-xs-12">
                                    <input type="text" class="form-control datepicker" name="date-completed" disabled="disabled"/>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group @if($errors->first('department-head')) has-error @endif">
                                <label class="col-md-3 col-xs-12 control-label">Department Head</label>
                                <div class="col-md-9 col-xs-12">
                                    <input type="text" class="form-control" name="department-head" value="{{ old('department-head') }}"/>
                                    @if($errors->first('department-head')) @component('layouts.error') {{ $errors->first('department-head') }} @endcomponent @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Date Confirmed By Department Head</label>
                                <div class="col-md-9 col-xs-12">
                                    <input type="text" class="form-control" name="date-confirmed-by" disabled="disabled"/>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12 col-xs-5">
                                    <button class="btn btn-primary btn-rounded pull-right">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
            <div class="col-md-3">

                <div class="panel panel-primary">
                    <div class="panel-body">
                        <h3>Search</h3>
                        <form id="faqForm">
                            <div class="input-group">
                                <input type="text" class="form-control" id="faqSearchKeyword" placeholder="Search..."/>
                                <div class="input-group-btn">
                                    <button class="btn btn-primary" id="faqSearch">Search</button>
                                </div>
                            </div>
                        </form>
                        <div class="push-up-10"><strong>Search Result:</strong> <span id="faqSearchResult">Please fill keyword field</span></div>
                        <div class="push-up-10">
                            <button class="btn btn-primary" id="faqRemoveHighlights">Remove Highlights</button>
                            <div class="pull-right">
                                <button class="btn btn-default" id="faqOpenAll"><span class="fa fa-angle-down"></span> Open All</button>
                                <button class="btn btn-default" id="faqCloseAll"><span class="fa fa-angle-up"></span> Close All</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-primary">
                    <div class="panel-body">
                        <h3>Contact</h3>
                        <p>Feel free to contact us for any issues you might have with our products.</p>
                        <div class="form-group">
                            <label>E-mail</label>
                            <input type="email" class="form-control" placeholder="youremail@domain.com">
                        </div>
                        <div class="form-group">
                            <label>Subject</label>
                            <input type="email" class="form-control" placeholder="Message subject">
                        </div>
                        <div class="form-group">
                            <label>Message</label>
                            <textarea class="form-control" placeholder="Your message" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <button class="btn btn-default"><span class="fa fa-paperclip"></span> Add attachment</button>
                        <button class="btn btn-success pull-right"><span class="fa fa-envelope-o"></span> Send</button>
                    </div>
                </div>

            </div>
        </div>

    </div>
@stop

@section('scripts')
    <script type="text/javascript" src="/js/plugins/bootstrap/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="{{ url('js/plugins/summernote/summernote.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/plugins/bootstrap/bootstrap-select.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/plugins/fileinput/fileinput.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/plugins/tagsinput/jquery.tagsinput.min.js') }}"></script>
    <script type="text/javascript">
        $(function(){
            $("#file-simple").fileinput({
                showUpload: false,
                showCaption: true,
                uploadUrl: "{{ route('revision-requests.store') }}",
                browseClass: "btn btn-primary",
                browseLabel: "Browse Document",
                allowedFileExtensions : ['.jpg']
            });

            /* Hidden placeholder */
            $('select option[disabled]:first-child').css('display', 'none');
        });

        $('#summernote').summernote({
            height: 300,
            toolbar: [
                ['misc', ['fullscreen']],
            ]
        });
    </script>

    <script>
        function showLink() {
            $('#span-reference').html("<a href="
                + "\"/documents/"
                + $('#reference').children(':selected').attr('id')
                + "\""
                + " target=\"_blank\">"
                + "Open "
                + $('#reference').children(':selected').html()
                + " in new tab"
                + "</a>");
        }

        $('#department-select').on('change', function() {
            $('#department-hint').empty().append("<span class=\"text text-info\">Do not forget to choose a branch too.</span>");
        });
    </script>
@stop