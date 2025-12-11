<?php

return [
    // Admin Dashboard
    'dashboard' => [
        'title' => 'Admin Dashboard',
        'welcome' => 'Welcome, Admin',
        'overview' => 'Overview',
        'statistics' => 'Statistics',
    ],

    // Mountains Management
    'mountains' => [
        'title' => 'Mountains Management',
        'add_mountain' => 'Add Mountain',
        'edit_mountain' => 'Edit Mountain',
        'mountain_name' => 'Mountain Name',
        'location' => 'Location',
        'height' => 'Height (MDPL)',
        'difficulty' => 'Difficulty Level',
        'description' => 'Description',
        'image' => 'Image',
        'price' => 'Base Price',
        'status' => 'Status',
        'actions' => 'Actions',
        'delete_confirm' => 'Are you sure you want to delete this mountain?',
    ],

    // Bookings Management
    'bookings' => [
        'title' => 'Bookings Management',
        'booking_code' => 'Booking Code',
        'customer' => 'Customer',
        'mountain' => 'Mountain',
        'check_in_date' => 'Check-in Date',
        'hikers' => 'Hikers',
        'total' => 'Total',
        'status' => 'Status',
        'actions' => 'Actions',
        'check_in' => 'Check In',
        'complete' => 'Complete',
        'view_details' => 'View Details',
        'filter_status' => 'Filter by Status',
        'filter_date' => 'Filter by Date',
        'export' => 'Export',
    ],

    // Quotas Management
    'quotas' => [
        'title' => 'Quota Management',
        'date' => 'Date',
        'quota' => 'Quota',
        'booked' => 'Booked',
        'available' => 'Available',
        'add_quota' => 'Add Quota',
        'edit_quota' => 'Edit Quota',
        'bulk_add' => 'Bulk Add Quotas',
        'start_date' => 'Start Date',
        'end_date' => 'End Date',
        'daily_quota' => 'Daily Quota',
    ],

    // Vouchers Management
    'vouchers' => [
        'title' => 'Vouchers Management',
        'add_voucher' => 'Add Voucher',
        'edit_voucher' => 'Edit Voucher',
        'code' => 'Voucher Code',
        'type' => 'Type',
        'value' => 'Value',
        'min_transaction' => 'Min. Transaction',
        'max_discount' => 'Max. Discount',
        'usage_limit' => 'Usage Limit',
        'used' => 'Used',
        'valid_from' => 'Valid From',
        'valid_until' => 'Valid Until',
        'status' => 'Status',
        'percentage' => 'Percentage',
        'fixed' => 'Fixed Amount',
        'voucher_report' => 'Voucher Report',
    ],

    // Trail Routes Management
    'trail_routes' => [
        'title' => 'Trail Routes',
        'add_route' => 'Add Route',
        'route_name' => 'Route Name',
        'distance' => 'Distance (km)',
        'estimated_time' => 'Estimated Time (hours)',
        'difficulty' => 'Difficulty',
        'description' => 'Description',
        'status' => 'Status',
        'toggle_status' => 'Toggle Status',
    ],

    // Notifications Management
    'notifications' => [
        'title' => 'Notifications Management',
        'add_notification' => 'Add Notification',
        'notification_title' => 'Title',
        'message' => 'Message',
        'type' => 'Type',
        'info' => 'Info',
        'warning' => 'Warning',
        'success' => 'Success',
        'danger' => 'Danger',
        'publish' => 'Publish',
        'delete' => 'Delete',
    ],

    // Analytics
    'analytics' => [
        'title' => 'Analytics Dashboard',
        'revenue' => 'Revenue',
        'total_bookings' => 'Total Bookings',
        'active_users' => 'Active Users',
        'popular_mountains' => 'Popular Mountains',
        'revenue_chart' => 'Revenue Chart',
        'bookings_chart' => 'Bookings Chart',
        'this_month' => 'This Month',
        'last_month' => 'Last Month',
        'growth' => 'Growth',
    ],

    // Validator
    'validator' => [
        'title' => 'Validator Dashboard',
        'scan_ticket' => 'Scan Ticket',
        'manual_check_in' => 'Manual Check-in',
        'booking_code' => 'Booking Code',
        'verify' => 'Verify',
        'check_in_success' => 'Check-in successful',
        'invalid_booking' => 'Invalid booking code',
        'already_checked_in' => 'Already checked in',
    ],
];
