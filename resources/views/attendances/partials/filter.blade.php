<form>
    <div class="form-row">
        @if (in_array('admin', auth()->user()->getRoleNames()->toArray()))
        <div class="form-group col-md-4">
            <label>{{ __('Name') }}</label>
            <select name="user_id" class="form-control form-control-sm form-rounded" id="user_id">
                @foreach ($employees as $employee)
                    <option value="{{ $employee->user_id }}"{{ $employee->user_id == auth()->user()->id ? ' selected' : '' }}>{{ $employee->user->name }}</option>
                @endforeach
            </select>
        </div>
        @endif

        <div class="form-group col-md-4">
            <label>{{ __('Date Range') }}</label>
            <div class="input-group input-group-sm">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fas fa-calendar"></i>
                    </div>
                </div>
                <input type="text" name="date_range" class="form-control form-control-sm daterange-cus" value="{{ Carbon\Carbon::now()->startOfMonth()->format('Y-m-d') . ' - ' . Carbon\Carbon::now()->endOfMonth()->format('Y-m-d') }}" id="date_range">
            </div>
        </div>

        <div class="form-group col-md-4">
            <label>&nbsp;</label><br>
            <button type="button" class="btn btn-sm btn-primary" onclick="filterAttendance()">{{ __('Apply') }}</button>
        </div>
    </div>
</form>