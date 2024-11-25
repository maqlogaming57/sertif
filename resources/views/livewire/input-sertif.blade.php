        <div class="my-3 p-3 bg-body rounded shadow-sm">
            <form>
                <div class="mb-3 row">
                    <label for="todo" class="col-sm-2 col-form-label">Nokontrak</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" wire:model="todo">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="tanggal" class="col-sm-2 col-form-label">Tanggal</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" wire:model="tanggal">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="jam" class="col-sm-2 col-form-label">jam</label>
                    <div class="col-sm-10">
                        <input type="time" class="form-control" wire:model="jam">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="status" class="col-sm-2 col-form-label">Status</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="status" wire:model="status">
                            <option value="">Pilih Status</option>
                            <option value="belum">Belum</option>
                            <option value="sedang">Sedang</option>
                            <option value="sudah">Sudah</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-10">
                        @if ($updateData == false)
                            <button type="button" class="btn btn-primary" name="submit" wire:click="store()">SIMPAN</button>
                        @else
                            <button type="button" class="btn btn-primary" name="submit" wire:click="update()">Update</button>
                        @endif
                        <button type="button" class="btn btn-secondary" name="submit" wire:click="clear()">Clear</button>
                    </div>
                </div>
            </form>
        </div>