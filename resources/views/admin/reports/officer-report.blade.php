<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: sans-serif; font-size: 12px; color: #1a1a1a; }

    .cover {
        text-align: center; padding: 80px 40px;
        border: 6px solid #1a5c2e;
        background: #f8fdf9; page-break-after: always;
    }
    .cover-main  { font-size: 28px; font-weight: 700; color: #1a5c2e; margin-bottom: 6px; }
    .cover-sub   { font-size: 14px; color: #555; margin-bottom: 28px; }
    .cover-line  { width: 80px; height: 3px; background: #1a5c2e; margin: 0 auto 24px; }
    .cover-report-title {
        font-size: 18px; font-weight: 700; color: #1a2e1e; margin-bottom: 24px;
    }
    .cover-officer-box {
        background: #1a5c2e; color: #fff;
        border-radius: 12px; padding: 20px 40px;
        display: inline-block; margin-bottom: 32px;
    }
    .cover-officer-name { font-size: 22px; font-weight: 700; margin-bottom: 6px; }
    .cover-officer-dist { font-size: 13px; color: #a5d6b0; }
    .cover-detail {
        font-size: 13px; color: #444; line-height: 2.4;
        margin-bottom: 24px; display: inline-block; text-align: left;
    }
    .cover-date { font-size: 11px; color: #888; margin-top: 8px; }

    .page-break { page-break-after: always; }

    .footer {
        position: fixed; bottom: 0; left: 0; right: 0;
        font-size: 9px; color: #888; text-align: center;
        padding: 6px; border-top: 1px solid #e0e8e2;
        background: #fff;
    }

    .section { margin-bottom: 22px; padding: 0 2px; }
    .section-title {
        font-size: 14px; font-weight: 700; color: #fff;
        background: #1a5c2e; padding: 9px 14px;
        border-radius: 6px; margin-bottom: 12px;
    }

    .info-box {
        background: #e8f5e9; border-left: 4px solid #1a5c2e;
        border-radius: 6px; padding: 10px 14px;
        font-size: 11px; color: #2d4a35; margin-bottom: 14px;
        line-height: 1.7;
    }

    .sub-label {
        font-size: 11px; font-weight: 600; color: #1a5c2e;
        margin-bottom: 6px; margin-top: 4px;
    }

    table { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
    thead { background: #1a5c2e; }
    th { color: #fff; padding: 8px 10px; font-size: 10px; text-align: left; font-weight: 600; }
    td { padding: 7px 10px; font-size: 11px; border-bottom: 1px solid #e8f5e9; }
    tr:nth-child(even) td { background: #f8fdf9; }
    tr:last-child td { border-bottom: none; }

    .badge-confirmed { background: #e8f5e9; color: #1a5c2e; padding: 2px 8px; border-radius: 10px; font-size: 10px; font-weight:600; }
    .badge-rejected  { background: #fce4ec; color: #993556; padding: 2px 8px; border-radius: 10px; font-size: 10px; font-weight:600; }
    .badge-pending   { background: #fff3e0; color: #854f0b; padding: 2px 8px; border-radius: 10px; font-size: 10px; font-weight:600; }
    .badge-published { background: #e8f5e9; color: #1a5c2e; padding: 2px 8px; border-radius: 10px; font-size: 10px; font-weight:600; }
    .badge-draft     { background: #f5f5f5; color: #666; padding: 2px 8px; border-radius: 10px; font-size: 10px; }

    .rating-high   { background: #e8f5e9; color: #1a5c2e; padding: 3px 10px; border-radius: 10px; font-size: 10px; font-weight: 600; }
    .rating-medium { background: #fff3e0; color: #854f0b; padding: 3px 10px; border-radius: 10px; font-size: 10px; font-weight: 600; }
    .rating-low    { background: #fce4ec; color: #993556; padding: 3px 10px; border-radius: 10px; font-size: 10px; font-weight: 600; }

    .conclusion {
        background: #f0fbf4; border: 1px solid #c8e6c9;
        border-radius: 8px; padding: 16px; margin-top: 16px;
    }
    .conclusion-title { font-size: 12px; font-weight: 700; color: #1a5c2e; margin-bottom: 8px; }
    .conclusion-text  { font-size: 11px; color: #2d4a35; line-height: 1.8; }
</style>
</head>
<body>

<!-- FOOTER -->
<div class="footer">
    PaddyCare Officer Performance Report | {{ $officer->name }} |
    Generated: {{ now()->format('F j, Y h:i A') }} | SLIATE Gampaha
</div>

<!-- ===== COVER PAGE ===== -->
<div class="cover">
    <div class="cover-main">PaddyCare</div>
    <div class="cover-sub">Paddy Disease Identification Web Application</div>
    <div class="cover-line"></div>
    <div class="cover-report-title">Officer Performance Report</div>

    <div class="cover-officer-box">
        <div class="cover-officer-name">{{ $officer->name }}</div>
        <div class="cover-officer-dist">
            Field Officer | {{ $officer->district ?? 'N/A' }} District
        </div>
    </div>

    <br>
    <div class="cover-detail">
        District &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $officer->district ?? 'N/A' }}<br>
        Email &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $officer->email }}<br>
        Phone &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $officer->phone ?? 'N/A' }}<br>
        Report Period : All Time
    </div>

    <div class="cover-date">
        Report Generated: {{ now()->format('l, F j, Y \a\t h:i A') }}
    </div>
</div>

<!-- ===== PAGE 2: PERFORMANCE OVERVIEW ===== -->
<div class="section">
    <div class="section-title">1. Performance Overview — {{ $officer->name }}</div>

    <div class="info-box">
        This report evaluates the performance of <strong>{{ $officer->name }}</strong>,
        Field Officer for <strong>{{ $officer->district ?? 'N/A' }}</strong> District,
        across three key metrics: Appointment Management, Diagnosis Review Rate,
        and Knowledge Contribution.
    </div>

    <table>
        <thead>
            <tr>
                <th style="width:33%; text-align:center;">Total Appointments</th>
                <th style="width:33%; text-align:center;">Diagnoses Reviewed</th>
                <th style="width:33%; text-align:center;">Articles Published</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align:center; font-size:22px; font-weight:700; color:#1a5c2e; padding:16px;">
                    {{ $stats['total_appointments'] }}
                </td>
                <td style="text-align:center; font-size:22px; font-weight:700; color:#1a5c2e; padding:16px;">
                    {{ $stats['diagnoses_reviewed'] }}
                </td>
                <td style="text-align:center; font-size:22px; font-weight:700; color:#1a5c2e; padding:16px;">
                    {{ $stats['articles_published'] }}
                </td>
            </tr>
        </tbody>
    </table>
</div>

<!-- ===== SECTION 2: APPOINTMENT MANAGEMENT ===== -->
<div class="section">
    <div class="section-title">2. Appointment Management</div>

    @php
        $total       = $stats['total_appointments'] ?: 1;
        $confirmRate = round(($stats['confirmed_appointments'] / $total) * 100);
        $rejectRate  = round(($stats['rejected_appointments']  / $total) * 100);
        $pendRate    = round(($stats['pending_appointments']   / $total) * 100);
        $apptRating  = $confirmRate >= 70 ? 'rating-high' : ($confirmRate >= 40 ? 'rating-medium' : 'rating-low');
        $apptLabel   = $confirmRate >= 70 ? 'Excellent' : ($confirmRate >= 40 ? 'Good' : 'Developing');
    @endphp

    <div class="info-box">
        Measures how efficiently the officer responds to farmer appointment requests.
        A high confirmation rate indicates strong farmer engagement and responsiveness.
    </div>

    <table>
        <thead>
            <tr>
                <th>Metric</th>
                <th>Count</th>
                <th>Percentage</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Confirmed Appointments</td>
                <td><strong>{{ $stats['confirmed_appointments'] }}</strong></td>
                <td>{{ $confirmRate }}%</td>
                <td><span class="badge-confirmed">Confirmed</span></td>
            </tr>
            <tr>
                <td>Rejected Appointments</td>
                <td><strong>{{ $stats['rejected_appointments'] }}</strong></td>
                <td>{{ $rejectRate }}%</td>
                <td><span class="badge-rejected">Rejected</span></td>
            </tr>
            <tr>
                <td>Pending Appointments</td>
                <td><strong>{{ $stats['pending_appointments'] }}</strong></td>
                <td>{{ $pendRate }}%</td>
                <td><span class="badge-pending">Pending</span></td>
            </tr>
            <tr style="background:#f0fbf4;">
                <td><strong>Total Appointments</strong></td>
                <td><strong>{{ $stats['total_appointments'] }}</strong></td>
                <td>100%</td>
                <td><span class="{{ $apptRating }}">{{ $apptLabel }}</span></td>
            </tr>
        </tbody>
    </table>

    @if($recentAppointments->count() > 0)
    <div class="sub-label">Recent Appointments (Last 5):</div>
    <table>
        <thead>
            <tr>
                <th>Farmer Name</th>
                <th>District</th>
                <th>Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($recentAppointments as $a)
            <tr>
                <td>{{ $a->farmer->name ?? '—' }}</td>
                <td>{{ $a->farmer->district ?? '—' }}</td>
                <td>{{ \Carbon\Carbon::parse($a->appointment_date)->format('M d, Y') }}</td>
                <td><span class="badge-{{ $a->status }}">{{ ucfirst($a->status) }}</span></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>

<div class="page-break"></div>

<!-- ===== SECTION 3: DIAGNOSIS REVIEW ===== -->
<div class="section">
    <div class="section-title">3. Diagnosis Review Rate</div>

    @php
        $reviewRate = $stats['total_diagnoses'] > 0
            ? round(($stats['diagnoses_reviewed'] / $stats['total_diagnoses']) * 100)
            : 0;
        $diagRating = $stats['diagnoses_reviewed'] >= 10 ? 'rating-high' : ($stats['diagnoses_reviewed'] >= 5 ? 'rating-medium' : 'rating-low');
        $diagLabel  = $stats['diagnoses_reviewed'] >= 10 ? 'Excellent' : ($stats['diagnoses_reviewed'] >= 5 ? 'Good' : 'Developing');
    @endphp

    <div class="info-box">
        Measures how quickly and thoroughly the officer reviews AI-generated diagnoses
        and provides expert advisory feedback to farmers.
        Out of <strong>{{ $stats['total_diagnoses'] }}</strong> total diagnoses in the system,
        <strong>{{ $officer->name }}</strong> has reviewed
        <strong>{{ $stats['diagnoses_reviewed'] }}</strong>.
    </div>

    <table>
        <thead>
            <tr>
                <th>Metric</th>
                <th>Value</th>
                <th>Rating</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Total Diagnoses Reviewed</td>
                <td><strong>{{ $stats['diagnoses_reviewed'] }}</strong></td>
                <td><span class="{{ $diagRating }}">{{ $diagLabel }}</span></td>
            </tr>
            <tr>
                <td>System-wide Total Diagnoses</td>
                <td><strong>{{ $stats['total_diagnoses'] }}</strong></td>
                <td>—</td>
            </tr>
            <tr>
                <td>Review Contribution Rate</td>
                <td><strong>{{ $reviewRate }}%</strong></td>
                <td>—</td>
            </tr>
        </tbody>
    </table>

    @if($recentDiagnoses->count() > 0)
    <div class="sub-label">Recent Diagnoses Reviewed (Last 5):</div>
    <table>
        <thead>
            <tr>
                <th>Farmer Name</th>
                <th>Disease Detected</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($recentDiagnoses as $d)
            <tr>
                <td>{{ $d->farmer->name ?? '—' }}</td>
                <td>{{ $d->disease->name ?? 'Healthy Leaf' }}</td>
                <td>{{ $d->created_at->format('M d, Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>

<!-- ===== SECTION 4: KNOWLEDGE CONTRIBUTION ===== -->
<div class="section">
    <div class="section-title">4. Knowledge Contribution — Articles</div>

    @php
        $artTotal  = $stats['articles_published'] + $stats['articles_draft'];
        $artRating = $stats['articles_published'] >= 5 ? 'rating-high' : ($stats['articles_published'] >= 2 ? 'rating-medium' : 'rating-low');
        $artLabel  = $stats['articles_published'] >= 5 ? 'Excellent' : ($stats['articles_published'] >= 2 ? 'Good' : 'Developing');
    @endphp

    <div class="info-box">
        Measures how actively the officer contributes educational content to the public
        article database. Articles covering irrigation, fertilizer, weed control,
        pest management and harvest planning help farmers make informed decisions.
    </div>

    <table>
        <thead>
            <tr>
                <th>Metric</th>
                <th>Count</th>
                <th>Rating</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Published Articles</td>
                <td><strong>{{ $stats['articles_published'] }}</strong></td>
                <td><span class="{{ $artRating }}">{{ $artLabel }}</span></td>
            </tr>
            <tr>
                <td>Draft Articles</td>
                <td><strong>{{ $stats['articles_draft'] }}</strong></td>
                <td>—</td>
            </tr>
            <tr style="background:#f0fbf4;">
                <td><strong>Total Articles Written</strong></td>
                <td><strong>{{ $artTotal }}</strong></td>
                <td>—</td>
            </tr>
        </tbody>
    </table>

    @if($articles->count() > 0)
    <div class="sub-label">Articles Written by {{ $officer->name }}:</div>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Category</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($articles as $i => $a)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ \Illuminate\Support\Str::limit($a->title, 45) }}</td>
                <td>{{ ucfirst($a->category) }}</td>
                <td>
                    @if($a->is_published)
                        <span class="badge-published">Published</span>
                    @else
                        <span class="badge-draft">Draft</span>
                    @endif
                </td>
                <td>{{ $a->created_at->format('M d, Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>

<div class="page-break"></div>

<!-- ===== SECTION 5: OVERALL SUMMARY ===== -->
<div class="section">
    <div class="section-title">5. Overall Performance Summary</div>

    @php
        $score = 0;
        if ($stats['total_appointments'] > 0)     $score++;
        if ($stats['confirmed_appointments'] >= 3) $score++;
        if ($stats['diagnoses_reviewed'] >= 5)     $score++;
        if ($stats['articles_published'] >= 2)     $score++;
        $overallClass = $score >= 3 ? 'rating-high' : ($score >= 2 ? 'rating-medium' : 'rating-low');
        $overallLabel = $score >= 3 ? 'Excellent' : ($score >= 2 ? 'Good' : 'Developing');
    @endphp

    <table>
        <thead>
            <tr>
                <th>Performance Metric</th>
                <th>Value</th>
                <th>Rating</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1. Appointment Management</td>
                <td>
                    {{ $stats['total_appointments'] }} total |
                    {{ $stats['confirmed_appointments'] }} confirmed
                    ({{ $confirmRate }}%)
                </td>
                <td><span class="{{ $apptRating }}">{{ $apptLabel }}</span></td>
            </tr>
            <tr>
                <td>2. Diagnosis Review Rate</td>
                <td>
                    {{ $stats['diagnoses_reviewed'] }} reviewed |
                    {{ $reviewRate }}% of system total
                </td>
                <td><span class="{{ $diagRating }}">{{ $diagLabel }}</span></td>
            </tr>
            <tr>
                <td>3. Knowledge Contribution</td>
                <td>
                    {{ $stats['articles_published'] }} published |
                    {{ $stats['articles_draft'] }} drafts
                </td>
                <td><span class="{{ $artRating }}">{{ $artLabel }}</span></td>
            </tr>
            <tr style="background:#f0fbf4;">
                <td><strong>Overall Performance Score</strong></td>
                <td><strong>Score: {{ $score }} / 4</strong></td>
                <td><span class="{{ $overallClass }}"><strong>{{ $overallLabel }}</strong></span></td>
            </tr>
        </tbody>
    </table>

    <div class="conclusion">
        <div class="conclusion-title">Conclusion</div>
        <div class="conclusion-text">
            This performance report evaluates <strong>{{ $officer->name }}</strong>,
            Field Agricultural Officer for <strong>{{ $officer->district ?? 'N/A' }}</strong>
            District, in the PaddyCare system. The officer has managed
            <strong>{{ $stats['total_appointments'] }}</strong> farmer appointment requests
            ({{ $stats['confirmed_appointments'] }} confirmed, {{ $confirmRate }}%
            confirmation rate), reviewed
            <strong>{{ $stats['diagnoses_reviewed'] }}</strong> AI-generated paddy disease
            diagnoses, and contributed
            <strong>{{ $stats['articles_published'] }}</strong> published educational
            articles to the farmer knowledge base.
            <br><br>
            Based on the three key performance metrics — Appointment Management,
            Diagnosis Review Rate, and Knowledge Contribution — the overall performance
            rating for this officer is <strong>{{ $overallLabel }}</strong>
            (Score: {{ $score }}/4). This report was generated by the PaddyCare System
            on {{ now()->format('F j, Y') }}.
        </div>
    </div>
</div>

</body>
</html>