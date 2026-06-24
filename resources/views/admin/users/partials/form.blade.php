@php($selectedDepartment = old('department_key', $user?->department_key))

<div class="col-md-6">
    <label class="form-label">Short name</label>
    <input name="name" value="{{ old('name', $user?->name) }}" class="form-control @error('name') is-invalid @enderror" required>
    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="col-md-6">
    <label class="form-label">Full name</label>
    <input name="full_name" value="{{ old('full_name', $user?->full_name) }}" class="form-control @error('full_name') is-invalid @enderror" required>
    @error('full_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="col-md-6">
    <label class="form-label">Email</label>
    <input type="email" name="email" value="{{ old('email', $user?->email) }}" class="form-control @error('email') is-invalid @enderror" required>
    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="col-md-6">
    <label class="form-label">Registration number</label>
    <input name="registration_number" value="{{ old('registration_number', $user?->registration_number) }}" class="form-control @error('registration_number') is-invalid @enderror">
    @error('registration_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="col-md-4">
    <label class="form-label">Role</label>
    <select name="role" class="form-select @error('role') is-invalid @enderror" required>
        @foreach ($roles as $role)
            <option value="{{ $role }}" @selected(old('role', $user?->role ?? 'student') === $role)>{{ ucfirst($role) }}</option>
        @endforeach
    </select>
    @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="col-md-4">
    <label class="form-label">Department key</label>
    <select name="department_key" class="form-select">
        <option value="">None</option>
        @foreach ($departments as $key => $department)
            <option value="{{ $key }}" @selected($selectedDepartment === $key)>{{ $department }}</option>
        @endforeach
    </select>
</div>
<div class="col-md-4">
    <label class="form-label">Phone</label>
    <input name="phone" value="{{ old('phone', $user?->phone) }}" class="form-control">
</div>
<div class="col-md-4">
    <label class="form-label">Sex</label>
    <select name="sex" class="form-select">
        <option value="">Select</option>
        <option value="M" @selected(old('sex', $user?->sex) === 'M')>M</option>
        <option value="F" @selected(old('sex', $user?->sex) === 'F')>F</option>
    </select>
</div>
<div class="col-md-8">
    <label class="form-label">Programme</label>
    <input name="programme" value="{{ old('programme', $user?->programme) }}" class="form-control">
</div>
<div class="col-md-6">
    <label class="form-label">Department</label>
    <input name="department" value="{{ old('department', $user?->department) }}" class="form-control">
</div>
<div class="col-md-3">
    <label class="form-label">Level</label>
    <input name="level" value="{{ old('level', $user?->level) }}" class="form-control">
</div>
<div class="col-md-3">
    <label class="form-label">Campus</label>
    <input name="campus" value="{{ old('campus', $user?->campus) }}" class="form-control">
</div>
<div class="col-md-6">
    <label class="form-label">Academic year</label>
    <input name="academic_year" value="{{ old('academic_year', $user?->academic_year) }}" class="form-control">
</div>
@if (! $user)
    <div class="col-md-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-3">
        <label class="form-label">Confirm password</label>
        <input type="password" name="password_confirmation" class="form-control" required>
    </div>
@endif
