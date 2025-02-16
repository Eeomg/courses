<div class="card-body">
    <div class="form-group">
        <x-input type="text" name='title' :value="$video->title" label="Video title" id="InputTitle"/>
    </div>
    <div class="form-group">
        <label class="">Description</label>
        <x-textarea name="description" :value="$video->description" />
    </div>
    <div class="form-group">
        <div class="custom-file">
            <label class="custom-file-label">video</label>
            <x-input type="file" name='video' class="custom-file-input"/>
        </div>
    </div>
</div>
<!-- /.card-body -->
<div class="card-footer">
    <button type="submit" class="btn btn-primary">Submit</button>
</div>

