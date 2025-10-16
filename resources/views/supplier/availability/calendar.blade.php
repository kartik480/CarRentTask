@extends('layouts.app')

@section('title', 'Availability Calendar - Supplier Panel')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-calendar-alt"></i> Availability Calendar</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('supplier.dashboard') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Select Car</h5>
            </div>
            <div class="card-body">
                @if($cars->count() > 0)
                    <div class="mb-3">
                        <label for="carSelect" class="form-label">Choose a car to view availability:</label>
                        <select class="form-select" id="carSelect">
                            <option value="">Select a car</option>
                            @foreach($cars as $car)
                                <option value="{{ $car->id }}">{{ $car->name }} ({{ $car->type }})</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="monthSelect" class="form-label">Month:</label>
                        <select class="form-select" id="monthSelect">
                            @for($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ $i == date('n') ? 'selected' : '' }}>
                                    {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="yearSelect" class="form-label">Year:</label>
                        <select class="form-select" id="yearSelect">
                            @for($i = date('Y'); $i <= date('Y') + 2; $i++)
                                <option value="{{ $i }}" {{ $i == date('Y') ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    
                    <button type="button" class="btn btn-primary w-100" id="loadCalendar">
                        <i class="fas fa-calendar"></i> Load Calendar
                    </button>
                @else
                    <div class="text-center py-3">
                        <i class="fas fa-car fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No approved cars found.</p>
                        <a href="{{ route('supplier.cars') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add Cars
                        </a>
                    </div>
                @endif
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0">Legend</h5>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                    <div class="availability-legend available me-2"></div>
                    <span>Available</span>
                </div>
                <div class="d-flex align-items-center mb-2">
                    <div class="availability-legend booked me-2"></div>
                    <span>Booked</span>
                </div>
                <div class="d-flex align-items-center mb-2">
                    <div class="availability-legend pending me-2"></div>
                    <span>Pending</span>
                </div>
                <div class="d-flex align-items-center">
                    <div class="availability-legend today me-2"></div>
                    <span>Today</span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-9">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Calendar View</h5>
            </div>
            <div class="card-body">
                <div id="calendarContainer">
                    <div class="text-center py-5">
                        <i class="fas fa-calendar-alt fa-4x text-muted mb-3"></i>
                        <h4 class="text-muted">Select a car to view availability</h4>
                        <p class="text-muted">Choose a car from the dropdown to see its booking calendar.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.availability-legend {
    width: 20px;
    height: 20px;
    border-radius: 3px;
    border: 1px solid #ddd;
}

.availability-legend.available {
    background-color: #d4edda;
}

.availability-legend.booked {
    background-color: #f8d7da;
}

.availability-legend.pending {
    background-color: #fff3cd;
}

.availability-legend.today {
    background-color: #cce5ff;
    border-color: #007bff;
}

.calendar-day {
    width: 14.28%;
    height: 40px;
    border: 1px solid #ddd;
    display: inline-block;
    text-align: center;
    line-height: 40px;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.2s;
}

.calendar-day:hover {
    background-color: #f8f9fa;
}

.calendar-day.available {
    background-color: #d4edda;
}

.calendar-day.booked {
    background-color: #f8d7da;
    color: #721c24;
}

.calendar-day.pending {
    background-color: #fff3cd;
    color: #856404;
}

.calendar-day.today {
    background-color: #cce5ff;
    border-color: #007bff;
    font-weight: bold;
}

.calendar-day.other-month {
    background-color: #f8f9fa;
    color: #6c757d;
}

.calendar-header {
    background-color: #007bff;
    color: white;
    font-weight: bold;
}

.calendar-weekday {
    width: 14.28%;
    display: inline-block;
    text-align: center;
    padding: 10px 0;
    font-weight: bold;
    background-color: #e9ecef;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const carSelect = document.getElementById('carSelect');
    const monthSelect = document.getElementById('monthSelect');
    const yearSelect = document.getElementById('yearSelect');
    const loadButton = document.getElementById('loadCalendar');
    const calendarContainer = document.getElementById('calendarContainer');

    loadButton.addEventListener('click', function() {
        const carId = carSelect.value;
        const month = monthSelect.value;
        const year = yearSelect.value;

        if (!carId) {
            alert('Please select a car first.');
            return;
        }

        loadCalendar(carId, month, year);
    });

    function loadCalendar(carId, month, year) {
        fetch(`{{ route('supplier.availability.data') }}?car_id=${carId}&month=${month}&year=${year}`)
            .then(response => response.json())
            .then(data => {
                renderCalendar(data, month, year);
            })
            .catch(error => {
                console.error('Error loading calendar:', error);
                calendarContainer.innerHTML = '<div class="alert alert-danger">Error loading calendar data.</div>';
            });
    }

    function renderCalendar(availabilityData, month, year) {
        const monthNames = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];

        const today = new Date();
        const currentMonth = parseInt(month);
        const currentYear = parseInt(year);
        
        const firstDay = new Date(currentYear, currentMonth - 1, 1);
        const lastDay = new Date(currentYear, currentMonth, 0);
        const startDate = new Date(firstDay);
        startDate.setDate(startDate.getDate() - firstDay.getDay());
        
        const endDate = new Date(lastDay);
        endDate.setDate(endDate.getDate() + (6 - lastDay.getDay()));

        let calendarHTML = `
            <div class="text-center mb-3">
                <h4>${monthNames[currentMonth - 1]} ${currentYear}</h4>
            </div>
            <div class="calendar-weekday">Sun</div>
            <div class="calendar-weekday">Mon</div>
            <div class="calendar-weekday">Tue</div>
            <div class="calendar-weekday">Wed</div>
            <div class="calendar-weekday">Thu</div>
            <div class="calendar-weekday">Fri</div>
            <div class="calendar-weekday">Sat</div>
            <div style="clear: both;"></div>
        `;

        const current = new Date(startDate);
        while (current <= endDate) {
            const dateStr = current.toISOString().split('T')[0];
            const isCurrentMonth = current.getMonth() === currentMonth - 1;
            const isToday = current.toDateString() === today.toDateString();
            
            let dayClass = 'calendar-day';
            let dayContent = current.getDate();
            let tooltip = '';

            if (!isCurrentMonth) {
                dayClass += ' other-month';
            } else {
                const dayData = availabilityData.find(d => d.date === dateStr);
                if (dayData) {
                    if (dayData.booking) {
                        if (dayData.booking.status === 'confirmed') {
                            dayClass += ' booked';
                            tooltip = `Booked by ${dayData.booking.customer}`;
                        } else if (dayData.booking.status === 'pending') {
                            dayClass += ' pending';
                            tooltip = `Pending booking by ${dayData.booking.customer}`;
                        }
                    } else {
                        dayClass += ' available';
                        tooltip = 'Available for booking';
                    }
                } else {
                    dayClass += ' available';
                    tooltip = 'Available for booking';
                }
            }

            if (isToday) {
                dayClass += ' today';
            }

            calendarHTML += `<div class="${dayClass}" title="${tooltip}">${dayContent}</div>`;
            current.setDate(current.getDate() + 1);
        }

        calendarContainer.innerHTML = calendarHTML;
    }
});
</script>
@endsection
