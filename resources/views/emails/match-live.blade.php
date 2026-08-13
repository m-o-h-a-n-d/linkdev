<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Match is LIVE Now!</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #060a12; color: #ffffff; margin: 0; padding: 20px; }
        .email-card { max-width: 600px; margin: 0 auto; background: #0e1626; border: 1px solid #1e293b; border-radius: 16px; padding: 30px; box-shadow: 0 20px 40px rgba(0,0,0,0.5); }
        .header-tag { display: inline-block; background: rgba(239, 68, 68, 0.2); border: 1px solid #ef4444; color: #ef4444; padding: 6px 16px; border-radius: 20px; font-weight: 800; font-size: 0.85rem; letter-spacing: 1px; text-transform: uppercase; margin-bottom: 16px; }
        .match-title { font-size: 1.6rem; color: #ffffff; margin: 0 0 10px 0; font-weight: 800; }
        .comp-meta { color: #ea580c; font-weight: 700; font-size: 0.95rem; margin-bottom: 24px; }
        .teams-box { background: #070c14; border: 1px solid #1e293b; border-radius: 12px; padding: 24px; text-align: center; margin-bottom: 24px; }
        .team-name { font-size: 1.3rem; font-weight: 800; color: #ffffff; display: inline-block; }
        .vs-badge { display: inline-block; background: #ea580c; color: #ffffff; font-weight: 900; padding: 4px 12px; border-radius: 12px; margin: 0 15px; font-size: 0.9rem; }
        .btn-watch { display: block; width: 100%; text-align: center; background: linear-gradient(135deg, #ea580c 0%, #c2410c 100%); color: #ffffff; text-decoration: none; padding: 14px 0; border-radius: 10px; font-weight: 800; font-size: 1rem; letter-spacing: 1px; }
        .footer { margin-top: 24px; text-align: center; font-size: 0.8rem; color: #64748b; }
    </style>
</head>
<body>
    <div class="email-card">
        <div class="header-tag">🔴 LIVE MATCH NOTIFICATION</div>
        <h1 class="match-title">Match Action is Live!</h1>
        <div class="comp-meta">{{ $match->competition->name ?? 'Handball Competition' }} &middot; {{ $match->group->name ?? 'Round ' . $match->round_number }}</div>

        <div class="teams-box">
            <span class="team-name">{{ $match->homeTeam->name ?? 'Home Team' }}</span>
            <span class="vs-badge">VS</span>
            <span class="team-name">{{ $match->awayTeam->name ?? 'Away Team' }}</span>
        </div>

        <p style="color: #cbd5e1; font-size: 0.95rem; line-height: 1.6; margin-bottom: 24px;">
            The handball match between <strong>{{ $match->homeTeam->name ?? 'Home Team' }}</strong> and <strong>{{ $match->awayTeam->name ?? 'Away Team' }}</strong> has just started live! Tune in now to follow live scores and real-time statistics.
        </p>

        <a href="{{ url('/matches/' . $match->id) }}" class="btn-watch">WATCH LIVE MATCH CENTER &rarr;</a>

        <div class="footer">
            &copy; {{ date('Y') }} Handball Hub System &middot; Sent to all registered handball fans.
        </div>
    </div>
</body>
</html>
