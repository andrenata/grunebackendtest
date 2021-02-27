@extends('backend/layout')
@section('content')
<section class="content-header">
    <h1>Company</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">{{ $company->page_title }}</li>
    </ol>
</section>
<!-- Main content -->
<div id="app">
    <section id="main-content" class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">{{ $company->page_title }}</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        {{ Form::open(array('route' => $company->form_action, 'method' => 'POST', 'files' => true, 'id' => 'company-form')) }}
                        {{ Form::hidden('id', $company->id, array('id' => 'company_id')) }}
                        <div id="form-display-name" class="form-group">
                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                                <span class="label label-danger label-required">Required</span>
                                <strong class="field-title">Name</strong>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                                {{ Form::text('display_name', $company->name, array('placeholder' => '', 'class' => 'form-control validate[required, maxSize[100]]', 'data-prompt-position' => 'bottomLeft:0,11')) }}
                            </div>
                        </div>

                        <div id="form-display-name" class="form-group">
                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                                <span class="label label-danger label-required">Required</span>
                                <strong class="field-title">Email</strong>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                                {{ Form::email('display_email', $company->email, array('placeholder' => '', 'class' => 'form-control validate[required, email, maxSize[100]]', 'data-prompt-position' => 'bottomLeft:0,11')) }}
                            </div>
                        </div>


                        <div id="form-display-name" class="form-group">
                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                                <span class="label label-danger label-required">Required</span>
                                <strong class="field-title">Postcode</strong>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-7 col-content">
                                <input type="text" name="display_postcode" id="postcode" v-model="postcode.id" class="form-control validate[required, maxSize[100]]">
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-content">
                                <a class="btn btn-primary" v-on:click="search(postcode.id)">Search</a>
                            </div>
                        </div>

                        
                        <div id="name"></div>

                        <div id="form-display-name" class="form-group">
                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                                <span class="label label-danger label-required">Required</span>
                                <strong class="field-title">Prefecture</strong>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                                {{ Form::select('display_prefecture', $prefectures->pluck('display_name','id'), $company->prefecture_id, array('placeholder' => '', 'class' => 'form-control validate[required, maxSize[100]]', 'data-prompt-position' => 'bottomLeft:0,11', 'v-bind:value' => 'postcode.prefecture')) }}
                            </div>
                        </div>

                        <div id="form-display-name" class="form-group">
                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                                <span class="label label-danger label-required">Required</span>
                                <strong class="field-title">City</strong>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                                {{ Form::text('display_city', $company->city, array('placeholder' => '', 'class' => 'form-control validate[required, maxSize[100]]', 'data-prompt-position' => 'bottomLeft:0,11', 'v-model' => 'postcode.city')) }}
                            </div>
                        </div>

                        <div id="form-display-name" class="form-group">
                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                                <span class="label label-danger label-required">Required</span>
                                <strong class="field-title">Local</strong>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                                {{ Form::text('display_local', $company->local, array('placeholder' => '', 'class' => 'form-control validate[required, maxSize[100]]', 'data-prompt-position' => 'bottomLeft:0,11', 'v-model' => 'postcode.city')) }}
                            </div>
                        </div>

                        <div id="form-display-name" class="form-group">
                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                                <strong class="field-title">Street Address</strong>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                                {{ Form::text('display_street', $company->street_address, array('placeholder' => '', 'class' => 'form-control validate[maxSize[100]]', 'data-prompt-position' => 'bottomLeft:0,11')) }}
                            </div>
                        </div>

                        <div id="form-display-name" class="form-group">
                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                                <strong class="field-title">Business Hour</strong>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                                {{ Form::text('display_hour', $company->business_hour, array('placeholder' => '', 'class' => 'form-control validate[maxSize[100]]', 'data-prompt-position' => 'bottomLeft:0,11')) }}
                            </div>
                        </div>

                        <div id="form-display-name" class="form-group">
                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                                <strong class="field-title">Regular Holiday</strong>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                                {{ Form::text('display_holiday', $company->regular_holiday, array('placeholder' => '', 'class' => 'form-control validate[maxSize[100]]', 'data-prompt-position' => 'bottomLeft:0,11')) }}
                            </div>
                        </div>

                        <div id="form-display-name" class="form-group">
                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                                <strong class="field-title">Phone</strong>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                                {{ Form::text('display_phone', $company->phone, array('placeholder' => '', 'class' => 'form-control validate[maxSize[100]]', 'data-prompt-position' => 'bottomLeft:0,11')) }}
                            </div>
                        </div>

                        <div id="form-display-name" class="form-group">
                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                                <strong class="field-title">Fax</strong>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                                {{ Form::text('display_fax', $company->fax, array('placeholder' => '', 'class' => 'form-control validate[maxSize[100]]', 'data-prompt-position' => 'bottomLeft:0,11')) }}
                            </div>
                        </div>

                        <div id="form-display-name" class="form-group">
                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                                <strong class="field-title">URL</strong>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                                {{ Form::text('display_url', $company->url, array('placeholder' => '', 'class' => 'form-control validate[maxSize[100]]', 'data-prompt-position' => 'bottomLeft:0,11')) }}
                            </div>
                        </div>

                        <div id="form-display-name" class="form-group">
                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                                <strong class="field-title">License Number</strong>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                                {{ Form::text('display_licence', $company->license_number, array('placeholder' => '', 'class' => 'form-control validate[maxSize[100]]', 'data-prompt-position' => 'bottomLeft:0,11')) }}
                            </div>
                        </div>

                        <div id="form-display-name" class="form-group">
                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                                <span class="label label-danger label-required">Required</span>
                                <strong class="field-title">Image</strong>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                                {{-- {{ Form::file('display_image', null, array('placeholder' => '', 'class' => 'form-control validate[required, maxSize[100]]', 'data-prompt-position' => 'bottomLeft:0,11', 'v-on:change' => 'upload')) }} --}}
                                <input name="display_image" type="file" v-on:change="upload">
                                <span>Max size image 2MB</span>
                            </div>
                        </div>

                        <div id="form-display-name" class="form-group">
                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                                @if($company->image)
                                    <div class="flexImage">
                                        <div>
                                            <p>Old Image</p>
                                            <?php $destinationimage = url('/uploads/files')."/".$company->image; ?>
                                            <img src="<?php echo $destinationimage; ?>" height="100">
                                        </div>
                                        <div>
                                        <p>New Image</p>
                                            <img :src="image.previewImg" v-if="image.previewImg" height="100">
                                        </div>
                                    </div>
                                @else
                                    <img :src="image.previewImg" v-if="image.previewImg" height="100">
                                @endif
                            </div>
                        </div>

                    

                        <div id="form-button" class="form-group no-border">
                            <div class="col-xs-12 col-sm-12 col-md-12 text-center" style="margin-top: 20px;">
                                <button type="submit" name="submit" id="send" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                        {{ Form::close() }}

                        <div id="content"></div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
</div>
<!-- /.content -->
@endsection

@section('title', 'company | ' . env('APP_NAME',''))

@section('body-class', 'custom-select')

@section('css-scripts')
@endsection

@section('js-scripts')
<script src="{{ asset('bower_components/bootstrap/js/tooltip.js') }}"></script>
<!-- validationEngine -->
<script src="{{ asset('js/3rdparty/validation-engine/jquery.validationEngine-en.js') }}"></script>
<script src="{{ asset('js/3rdparty/validation-engine/jquery.validationEngine.js') }}"></script>
<script src="{{ asset('js/backend/companies/form.js') }}"></script>



<script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
  const vm = new Vue({
      el : '#app',
      data: function() {
        return {
            image: {
                previewImg: "{{ asset('img/no-image/no-image.jpg') }}",
                nameImg: ""
            },
            postcode: {
                id: "",
                city: "",
                local: "",
                prefecture: ""
            },
            postcodes: {}
        }
      },
      methods: {
        upload: function(event){
            // console.log(event.target.files[0])
            this.image.nameImg = event.target.files[0].name
            this.image.previewImg = URL.createObjectURL(event.target.files[0])
        },
        search: function(id){
            // console.log(this.postcode.id);
            let uri = `search/${id}`;
            // console.log(uri);
            axios.get(uri).then((response) => {
                this.postcodes = response.data[0];
                this.postcode.city = this.postcodes.city;
                this.postcode.local = this.postcodes.local;
                this.postcode.prefecture = this.postcodes.id;

                // console.log(this.postcodes);
            });

            e.preventDefault();
        }
      }
  })
</script>


@endsection
