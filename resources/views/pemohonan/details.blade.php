@extends('layouts.admin.template_admin')
@section('content')
<div>

{{-- edit employee modal start --}}
<div class="modal fade" id="editTUModal" tabindex="-1" aria-labelledby="exampleModalLabel"
data-bs-backdrop="static" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Edit TU</h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <form action="#" method="POST" id="edit_TU_form" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="emp_id" id="emp_id">
      <input type="hidden" name="emp_image" id="upload_data">
      <div class="modal-body p-4 bg-light">
          <div class="my-2">
            <label for="entry_data">Entry Data</label>
            <input type="text" name="entry_data" id="entry_data" class="form-control" placeholder="Masukan Entry Data">
          </div>
        <div class="my-2">
          <label for="upload_data">Select Image</label>
          <input type="file" name="upload_data" class="form-control">
        </div>
        <div class="mt-2" id="image">

        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" id="edit_TU_btn" class="btn btn-success">Update</button>
      </div>
    </form>
  </div>
</div>
</div>
{{-- edit employee modal end --}}
<div class="card">
  <div class="card-header text-center"><h2>{{ $permohonans->layanan->nama_layanan }}</h2></div>
  <div class="card-body">
      <div class="row">
          <div class="col-lg-12">
            <div class="card shadow">
              <div class="card-body" id="">
                <table class="table table-striped table-sm text-center align-middle">
                  <thead>
                      <th>Nama Pemohon</th>
                      <th>No KK</th>
                      <th>NIK</th>
                      <th>No HP</th>
                      <th>Alamat</th>
                      <th>Email</th>
                      <th>Akun Pengaju</th>
                  </thead>
                  <tbody>
                      @foreach ($pemohon as $item)
                          <tr>
                              <td>{{ $item->nama_pemohon }}</td>
                              <td>{{ $item->no_kk }}</td>
                              <td>{{ $item->nik }}</td>
                              <td>{{ $item->no_hp }}</td>
                              <td>{{ $item->alamat }}</td>
                              <td>{{ $item->email }}</td>
                              <td>{{ $item->user->name }}</td>
                          </tr>
                      @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
      </div>
  </div>
  <div class="card-body">
      <div class="row">
          <div class="col-lg-12">
            <div class="card shadow">
              <div class="card-body" id="TU_all">
              </div>
            </div>
          </div>
      </div>
  </div>
  <div class="ml-4 mb-3">
      <a href="/pemohonan" class="btn btn-primary">Kembali</a>
  </div>
</div>
</div>
@endsection


@section('js')

      <script>
    $(function() {

            // edit employee ajax request
      $(document).on('click', '.editIcon', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        $.ajax({
          url: '{{ route('rincian_layanan-edit') }}',
          method: 'get',
          data: {
            id: id,
            _token: '{{ csrf_token() }}'
          },
          success: function(response) {
            $("#entry_data").val(response.entry_data);
            $("#upload_data").val(response.upload_data);
            $("#image").html(
              `<img src="/storage/public/images/${response.upload_data}" width="100" class="img-fluid img-thumbnail" alt="kosong">`);
            $("#emp_id").val(response.id);
          }
        });
      });

         // update employee ajax request
      $("#edit_TU_form").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $("#edit_TU_btn").text('Updating...');
        $.ajax({
          url: '{{ route('rincian_layanan-update') }}',
          method: 'post',
          data: fd,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) {
            if (response.status == 200) {
              Swal.fire(
                'Updated!',
                'Updated Successfully!',
                'success'
              )
              TU_all();
            }
            $("#edit_TU_btn").text('Update');
            $("#edit_TU_form")[0].reset();
            $("#editTUModal").modal('hide');
          }
        });
      });

        TU_all();
      function TU_all() {
        $.ajax({
          url: '{{ route('rincian_layanan-detail_detail', $permohonans->id) }}',
          method: 'get',
          success: function(response) {
            $("#TU_all").html(response);
            $("table").DataTable({
                  destroy: true,
            });
          }
        });
      }
    });
  </script>
@endsection
