@extends('pages.dashboard.layouts.main')

@section('title', $title)

@section('additional_links')
    @include('utils.choices.link')
    @include('utils.flatpickr.link')
@endsection

@section('content')
    <div class="page-title">
        <div class="row">
            <div class="order-last col-12 col-md-6 order-md-1">
                <h3>Buat Peminjaman</h3>
                <p class="text-subtitle text-muted">
                    Buat Peminjaman baru untuk pembaca yang ingin membaca buku dan membawanya kembali nanti.
                </p>
            </div>
            <div class="order-first col-12 col-md-6 order-md-2">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="/dashboard/receipts">Peminjaman</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Peminjaman</h4>
            </div>
            <div class="card-body">
                <form class="form" action="/dashboard/receipts" method="POST">
                    @csrf

                    <div class="row">
                        <div class="mb-1 col-md-6 col-12">
                            <div class="form-group has-icon-left mandatory @error('id_user'){{ 'is-invalid' }}@enderror">
                                <label for="user" class="form-label">User</label>
                                <div class="position-relative">
                                    <!-- Menampilkan nama lengkap user yang sedang login -->
                                    <input type="text" class="form-control" value="{{ Auth::user()->nama_lengkap }}" readonly>
                                    <!-- Menyimpan id_user yang sedang login dalam input hidden -->
                                    <input type="hidden" name="id_user" value="{{ Auth::user()->id_user }}">

                                    @error('id_user')
                                        <div style="margin-top: -20px" class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>



                        <div class="mb-1 col-md-6 col-12">
                            <div class="form-group has-icon-left mandatory @error('id_buku'){{ 'is-invalid' }}@enderror">
                                <label for="book" class="form-label">Buku</label>
                                <div class="position-relative">
                                    <select id="book" class="choices form-select" name="id_buku">
                                        <option placeholder>Silakan pilih bukunya...</option>
                                        @foreach ($books as $book)
                                            <option value="{{ $book->id_buku }}"
                                                @if (old('id_buku') == $book->id_buku) selected @elseif ($book->id_buku == $id_buku) selected @endif>{{ $book->judul }}
                                                ({{ $book->stock }})
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('id_buku')
                                        <div style="margin-top: -20px" class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-1 col-12">
                            <div class="form-group has-icon-left mandatory @error('jumlah'){{ 'is-invalid' }}@enderror">
                                <label for="jumlah" class="form-label">Jumlah</label>
                                <div class="position-relative">
                                    <input type="text" class="py-2 form-control" id="jumlah" name="jumlah"
                                        value="{{ old('jumlah') }}" placeholder="e.g. 5" min="0" max="5"
                                        maxlength="1" />
                                    <div class="form-control-icon">
                                        <i class="py-2 bi bi-bar-chart"></i>
                                    </div>

                                    @error('jumlah')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-1 col-md-6 col-12">
                            <div
                                class="form-group has-icon-left mandatory @error('tanggal_peminjaman'){{ 'is-invalid' }}@enderror">
                                <label for="tanggal_peminjaman" class="form-label">Dari Tanggal</label>
                                <div class="position-relative">
                                    <input name="tanggal_peminjaman" id="tanggal_peminjaman" type="date"
                                        class="mb-2 form-control flatpickr-from" placeholder="Pilih tanggal ..."
                                        value="{{ old('tanggal_peminjaman') ?? date('Y-m-d') }}">
                                    <div class="form-control-icon">
                                        <i class="py-2 bi bi-calendar-day"></i>
                                    </div>

                                    @error('tanggal_peminjaman')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-1 col-md-6 col-12">
                            <div class="form-group has-icon-left mandatory @error('tanggal_pengembalian'){{ 'is-invalid' }}@enderror">
                                <label for="tanggal_pengembalian" class="form-label">Sampai Tanggal</label>
                                <div class="position-relative">
                                    <input name="tanggal_pengembalian" id="tanggal_pengembalian" type="date"
                                        class="mb-2 form-control flatpickr-to" placeholder="Pilih tanggal ..."
                                        value="{{ old('tanggal_pengembalian') }}">
                                    <div class="form-control-icon">
                                        <i class="py-2 bi bi-calendar-check"></i>
                                    </div>

                                    @error('tanggal_pengembalian')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 d-flex justify-content-end">
                            <button type="submit" class="mb-1 btn btn-primary me-1">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@section('additional_scripts')
    @include('utils.choices.script')
    @include('utils.flatpickr.script')
    <script>
        const localDate = "{{ now()->format('Y-m-d') }}";
        const dateGapBetweenFromAndTo = `{{ now()->subDays(-7)->format('Y-m-d') }}`;
        const dateToDefaultStart = `{{ now()->subDays(-1)->format('Y-m-d') }}`;

        const config = {
            from: {
                dateFormat: "Y-m-d",
                minDate: localDate,
                maxDate: localDate,
            },
            to: {
                dateFormat: "Y-m-d",
                minDate: dateToDefaultStart,
                maxDate: dateGapBetweenFromAndTo,
                defaultDate: dateToDefaultStart,
            },
        };

        flatpickr(".flatpickr-from", config.from);
        flatpickr(".flatpickr-to", config.to);
    </script>
@endsection
