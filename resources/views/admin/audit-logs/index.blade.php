@extends('layouts.admin')

@section('page_title', 'System Audit Trail')

@section('content')
<div class="space-y-6">
    <div>
        <h2 class="font-display text-xl font-bold text-charcoal-900">System Audit Trail</h2>
        <p class="text-xs text-charcoal-500">Immutable chronological log of all administrative actions, status updates, and modifications.</p>
    </div>

    {{-- Filter Bar --}}
    <div class="bg-white rounded-xl p-4 border border-charcoal-100 shadow-sm">
        <form action="{{ route('admin.audit-logs.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-4 gap-3 items-end">
            <div>
                <label class="block text-[11px] font-semibold uppercase text-charcoal-500 mb-1">Action Type</label>
                <input type="text" name="action" value="{{ request('action') }}" placeholder="E.g. created, updated, status_updated" class="form-input text-xs">
            </div>
            <div>
                <label class="block text-[11px] font-semibold uppercase text-charcoal-500 mb-1">Date</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="form-input text-xs">
            </div>
            <div class="flex gap-2 sm:col-span-2">
                <button type="submit" class="btn-secondary btn-sm">Filter Audit Logs</button>
                <a href="{{ route('admin.audit-logs.index') }}" class="btn-outline btn-sm">Reset</a>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-xl border border-charcoal-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Timestamp</th>
                        <th>User</th>
                        <th>Action</th>
                        <th>Entity</th>
                        <th>IP Address</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                        <tr>
                            <td class="text-xs text-charcoal-500 whitespace-nowrap">{{ $log->created_at->format('d M Y, H:i:s') }}</td>
                            <td>
                                <span class="font-semibold text-charcoal-900 text-xs">{{ $log->user->name ?? 'System' }}</span>
                                @if($log->user)
                                    <span class="text-[10px] text-charcoal-400 block">{{ ucfirst($log->user->role) }}</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge badge-secondary text-[10px] uppercase font-mono">{{ $log->action }}</span>
                            </td>
                            <td class="text-xs text-charcoal-800">
                                {{ class_basename($log->auditable_type) }} #{{ $log->auditable_id }}
                            </td>
                            <td class="font-mono text-xs text-charcoal-500">{{ $log->ip_address ?? '127.0.0.1' }}</td>
                            <td class="text-xs text-charcoal-600 max-w-xs truncate">
                                @if($log->new_values)
                                    <span class="font-mono text-[11px]">{{ json_encode($log->new_values) }}</span>
                                @else
                                    —
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-xs text-charcoal-400">No audit logs recorded.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-charcoal-100">
            {{ $logs->links() }}
        </div>
    </div>
</div>
@endsection
