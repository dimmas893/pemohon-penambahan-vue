@extends('layouts.admin.template_admin')
@section('content')
    <div class="">

















        <div class="">
            <div class="container">
                <ul class="nav nav-pills nav-fill" id="pills-tab" role="tablist">
                    <li class="nav-item" style="display:none">
                        <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-1" role="tab"></a>
                    </li>
                    <li class="nav-item" style="display:none">
                        <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-2" role="tab">Service Requirements</a>
                    </li>
                </ul>
            </div>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-1" role="tabpanel" aria-labelledby="pills-home-tab">
                    <div class="card">
                        <div class="card-header text-center">
                            Review
                            {{-- <p id="demo"></p> --}}
                        </div>
                        @php
                            $layanan = \App\Models\Layanan::where('id' ,  $id_layanan)->first();
                            $user = \App\Models\User::where('id' ,  $id_user)->first();
                            // $pemohon = \App\Models\Pemohon::where('id' ,  1)->first();
                        @endphp
                        <div class="ml-3 mt-3">
                            <label for="">Nama Layanan : {{$layanan->nama_layanan}} </label>
                        </div>

                        <div class="ml-3 mt-3">
                            <label for="">User : {{ $user->name }} </label>
                        </div>
                        <br>
                        <div class="ml-3 mt-3">
                            <label for="">Nama Pemohon : {{ $nama_pemohon }} </label>
                        </div>
                        <div class="ml-3">
                            <label for="">Alamat : {{ $no_hp }} </label>
                        </div>
                        <div class="ml-3">
                            <label for="">Email : {{ $email }} </label>
                        </div>
                        <div class="ml-3">
                            <label for="">No KK : {{ $no_kk }} </label>
                        </div>
                        <div class="ml-3">
                            <label for="">NIK : {{ $nik }} </label>
                        </div>
                        <h2 class="ml-3 mt-3">Persyaratan</h2>


                        <div class="row">
                            <div class="col-6">
                                @foreach ($entry_data as $item)
                                    <ol>{{$item}}</ol>
                                @endforeach
                            </div>

                            <div class="col-6">
                                @foreach ($upload_data as $item)
                                    <li><img src="/storage/public/images/{{$item}}" width="100px"></li>
                                @endforeach
                            </div>
                        </div>
                        <?php $cocote = 0; ?>
                        <div class="row">
                            <div class="col-6 ml-2 mt-2 mb-2" >
                                <form action="{{ route('pemohon-storeakhir') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="nik" value="{{$nik}}" />
                                    <input type="hidden" name="no_kk" id="demo" />
                                    <input type="hidden" name="nama_pemohon" value="{{$nama_pemohon}}" />
                                    <input type="hidden" name="alamat" value="{{$alamat}}" />
                                    <input type="hidden" name="no_hp" value="{{$no_hp}}" />
                                    <input type="hidden" name="email" value="{{$email}}" />
                                    <input type="hidden" name="id_user" value="{{$id_user}}" />
                                    <input type="hidden" name="id_layanan" value="{{$id_layanan}}" />
                                    <input type="hidden" name="id" value="{{$id_layanan}}" />
                                    @foreach ($entry_data as $item)
                            {{-- {{        dd($item);}} --}}

                                        <input type="hidden" name="entry_data{{ $cocote }}[]" value="{{$item}}"/>
                                    @endforeach

                                    @foreach ($upload_data as $item)
                                    <input type="hidden" name="upload_data{{ $cocote }}[]" value="{{$item}}" />
                                @endforeach
                                    <input type="submit" class="btn btn-primary" value="save">
                                </form>
                            </div>
                            <div class="col-6">
                            </div>

                            <?php $cocote++; ?>
                        </div>
                    </div>
                    <div class="col-6 col-sm-3" id="btnNext">
                        <a class="btn btn-info btnNext">Kembali</a>
                    </div>
                </div>











                <div class="tab-pane fade" id="pills-2" role="tabpanel" aria-labelledby="pills-profile-tab">
                    <div class="card">
                        <div class="card-header text-center">
                            Isi Data{{ \App\Models\Layanan::where('id', $id_layanan)->first()->nama_layanan }}
                        </div>
                        <div class="card-body text-center">
                            <h2>Persyaratan</h2>
                            <div class="row text-left">
                                <div class="col-12">

                                        <form action="/pemohon/store" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-body p-4 bg-light">
                                                <div class="my-2">
                                                    <label for="nik">NIK</label>
                                                    <input type="text" name="nik" class="form-control" value="{{ $nik }}" placeholder="Masukan NIK" required>
                                                </div>
                                                <div class="my-2">
                                                  <label for="no_kk">No KK</label>
                                                  <input type="text" name="no_kk" class="form-control" value="{{ $no_kk }}" placeholder="Masukan No KK" required>
                                              </div>
                                              <div class="my-2">
                                                <label for="nama_pemohon">Nama Pemohon</label>
                                                <input type="text" name="nama_pemohon" class="form-control" value="{{ $nama_pemohon }}" placeholder="Masukan Nama Pemohon" required>
                                            </div>
                                            <div class="my-2">
                                                <label for="alamat">Alamat</label>
                                                <textarea type="text" name="alamat"class="form-control" value="{{ $alamat }}" placeholder="Masukan Alamat" required></textarea>
                                            </div>
                                            <div class="my-2">
                                                <label for="no_hp">No HP</label>
                                                <input type="text" name="no_hp" class="form-control" value="{{ $no_hp }}" placeholder="Masukan No HP" required>
                                            </div>
                                            <div class="my-2">
                                                <label for="email">Email</label>
                                                <input type="email" name="email" class="form-control" value="{{ $email }}" placeholder="Masukan Email" required>
                                            </div>

                                            </div>
                                            <div class="modal-footer">
                                            </div>

                                            <input type="hidden" name="id" value="{{ $id_layanan }}">
                                            <input type="hidden" name="id_persyaratan" value="{{ $id_persyaratan }}">
                                            <input type="hidden" name="id_layanan" value="{{ $id_layanan }}">

                                            <?php $cocote = 0; ?>

                                    @foreach (\App\Models\Rincian_layanan::with('layanan', 'persyaratan')->where('id_layanan', $id_layanan)->get() as $item =>$value)
                                            {{-- {{dd($value);}} --}}
                                           {{-- {{ dd($entry_data);}} --}}


                                            {{-- {{dd($upload_data);}} --}}



                                            @if($value->persyaratan->entry_data != null && $value->persyaratan->upload_data != null)
                                            <div class="row">
                                                    <label class="mt-2" for="">{{ $value->persyaratan->nama_persyaratan }}</label>
                                                    <div class="col-6">
                                                        <input type="text" name="entry_data{{ $cocote }}[]" value="" class="form-control"/>
                                                    </div>
                                                    <div class="col-6">
                                                        <input type="file" name="upload_data{{ $cocote }}[]" value="" class="form-control"/>
                                                    </div>
                                                </div>

                                            @elseif($value->persyaratan->upload_data == 1 && $value->persyaratan->entry_data == null)
                                                <label class="mt-2" for="">{{ $item->persyaratan->nama_persyaratan }}</label>
                                                <input type="file" name="upload_data{{ $cocote }}[]" class="form-control"/>
                                            @elseif($value->persyaratan->upload_data == null && $value->persyaratan->entry_data == 1)
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label class="mt-2" for="">{{ $value->persyaratan->nama_persyaratan }}</label>
                                                        <input type="text" name="entry_data{{ $cocote }}[]" class="form-control"/>
                                                    </div>
                                                </div>
                                                @endif
                                                @endforeach

                                                <?php $cocote++; ?>
                                            <button type="submit" id="layanan_button" class="btn btn-primary">Save</button>
                                        </form>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <div class="navbuttons">
                        <div class="col-6 col-sm-3" id="btnPrevious">
                            <a class="btn btn-primary btnPrevious">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>





    </div>


@endsection
@section('js')


<script>
    $('.btnNext').click(function() {
    $('.nav-pills .active').parent().next('li').find('a').trigger('click');
});

$('.btnPrevious').click(function() {
    $('.nav-pills .active').parent().prev('li').find('a').trigger('click');
});
    // Set Item
    localStorage.setItem("lastname", "{{ $nik }}");
    // Retrieve
    document.getElementById("demo").innerHTML = localStorage.getItem("lastname");
    </script>
@endsection
