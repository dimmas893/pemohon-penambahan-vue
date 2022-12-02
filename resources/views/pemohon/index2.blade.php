@extends('layouts.admin.template_admin')
@section('content')
    <div class="card" id="app">
        <div class="card-header text-center">
            Pilih Layanan
        </div>
        <div class="card-body">

        <form action="/pemohon/store" method="post">
                @csrf
            <div class="modal-body p-4 bg-light">
                <div class="my-2">
                    <label for="nik">@{{isinik}}</label>
                    <input type="text" name="nik" class="form-control" v-model="isinik" placeholder="Masukan NIK" required>
                </div>
                <div class="my-2">
                  <label for="no_kk">No KK</label>
                  <input type="text" name="no_kk" class="form-control" placeholder="Masukan No KK" required>
              </div>
              <div class="my-2">
                <label for="nama_pemohon">Nama Pemohon</label>
                <input type="text" name="nama_pemohon" class="form-control" value="" placeholder="Masukan Nama Pemohon" v-model="nama_pemohon" required>
            </div>
            <div class="my-2">
                <label for="alamat">Alamat</label>
                <textarea type="text" name="alamat"class="form-control" placeholder="Masukan Alamat" required></textarea>
            </div>
            <div class="my-2">
                <label for="no_hp">No HP</label>
                <input type="text" name="no_hp" class="form-control" placeholder="Masukan No HP" required>
            </div>
            <div class="my-2">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Masukan Email" required>
                </div>
            </div>

            <div class="my-2">
                <select class="form-control js-example-basic-multiple" name="layanan_id" id="layanan_id">
                    @foreach($layanan as $p)
                        <option value="{{ $p->id }}"> {{ $p->nama_layanan }} </option>
                    @endforeach
                </select>
            </div>

                <input type="submit" value="pilih" class="btn btn-primary mt-2">
            </form>
            <form action="/pemohon/store" method="POST" enctype="multipart/form-data">
                @csrf


                <div v-for="item in infoLayanan" class="row mt-4">
                    <div class="col-12">
                        <label for=""><h2>@{{ item.nama_persyaratan }}</h2></label>
                    </div>
                    <div class="col-6" v-if="item.entry_data === 1">
                        <label class="mt-2" for="entry data">Entry Data</label>
                        <input type="text" name="entry_data[]" v-model="item.isiEntri" class="form-control"/>
                    </div>

                    <div class="col-6" v-if="item.upload_data === 1">
                        <label class="mt-2" for="upload data">upload Data</label>
                        <input type="file" name="upload_data[]" v-model="item.upload" onchange="str()" class="form-control"/>
                        <script type="text/"></script>
                    </div>
                </div>

                {{-- <button type="submit" id="layanan_button" class="btn btn-primary">Preview</button> --}}
            </form>

            <div class="card">
                <div class="card-header text-center">
                    Review
                    {{-- <p id="demo"></p> --}}
                </div>
                <div class="ml-3 mt-3">
                    <label for="">Nama Layanan  </label>
                </div>

                <div class="ml-3 mt-3">
                    <label for="">User :  </label>
                </div>
                <br>
                <div class="ml-3 mt-3">
                    <label for="">Nama Pemohon : @{{ nama_pemohon }} </label>
                </div>
                <div class="ml-3">
                    <label for="">Alamat :  </label>
                </div>
                <div class="ml-3">
                    <label for="">Email :  </label>
                </div>
                <div class="ml-3">
                    <label for="">No KK :  </label>
                </div>
                <div class="ml-3">
                    <label for="">NIK : </label>
                </div>
                <h2 class="ml-3 mt-3">Persyaratan</h2>


                <div v-for="item in infoLayanan" class="row mt-4">
                    <div class="col-12">
                        <label for=""><h2>@{{ item.nama_persyaratan }}</h2></label>
                    </div>

                    <div class="col-6" v-if="item.entry_data === 1">
                        <label class="mt-2" for="entry data">Entry Data</label>
                        <input type="text" name="entry_data[]" v-model="item.isiEntri" class="form-control"/>
                    </div>

                    <div class="col-6" v-if="item.upload_data === 1">
                        <label class="mt-2" for="upload data">Upload Data @{{ item.upload }}</label>
                        <input type="file" name="upload_data[]" class="form-control"/>
                    </div>

                </div>


                <div class="row">
                    <div class="col-6 ml-2 mt-2 mb-2" >
                        <form action="{{ route('pemohon-storeakhir') }}" method="post" enctype="multipart/form-data">
                            @csrf

                            <input type="submit" class="btn btn-primary" value="save">
                        </form>
                    </div>
                    <div class="col-6">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



@section('js')
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.14"></script>
<script src="https://cdn.jsdelivr.net/vue.resource/1.3.1/vue-resource.min.js"></script>

    <script>
        // $(document).ready(function() {
        //     $('.js-example-basic-multiple').select2();
        // });



        (function ($) {
            var _token = '<?php echo csrf_token() ?>';
            $(document).ready(function() {
                var app = new Vue({
                    el: '#app',
                    data: {
                        isinik:'',
                        layanan: '',
                        nik: '',
                        nama_pemohon: '',
                        id_pemohon: '',
                        no_kk: '',
                        alamat: '',
                        infoLayanan: [],
                        namalayanan: [],
                            infoPemohon:{
                                id:'',
                                nik:'',
                                no_kk:'',
                                alamat:'',
                            }
                    },
                    watch: {
                        'layanan': function() {
                            if(this.layanan) {
                                this.getInfoLayanan(),
                                this.getnamaLayanan()
                            }
                        },
                        'infoPemohon.id': function() {
                            if(this.infoPemohon){
                                this.getInfoPemohon()
                            }
                        },

                    },


                    // awal mounted
                    mounted:function(){
                        $('#layanan_id').select2({
                            witdh: '100%'
                        }).on('change' , () => {
                            this.layanan = $('#layanan_id').val();
                        });
                        $('#pemohon_id').select2({
                            witdh: '100%'
                        }).on('change' , () => {
                            this.infoPemohon.id = $('#pemohon_id').val();
                        });
                    },
                    // akhir mounted

                    //awal method
                    methods: {

                        getInfoLayanan() {
                            this.$http.get(`/infoLayanan/${this.layanan}`)
                                .then((response) =>{
                                    this.infoLayanan = response.data
                                })
                        },
                        getnamaLayanan() {
                            this.$http.get(`/namaLayanan/${this.layanan}`)
                                .then((response) => {
                                    this.namalayanan = response.data
                                })
                        },
                        getInfoPemohon() {
                            this.$http.get(`/infoPemohon/${this.infoPemohon.id}`)
                                .then((response) => {
                                    this.infoPemohon = response.data
                                })
                        },
                    },
                    //akhir method

                });
            });
        })(jQuery);
    </script>
@endsection
