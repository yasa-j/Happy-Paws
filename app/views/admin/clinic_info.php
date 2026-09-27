<div class="subpage-card">
    <div class="subpage-header">
        <h1 class="subpage-title">
            Clinic Details & Public Profile
        </h1>

        <button
            class="panel-action-btn"
            style="border:none; cursor:pointer; font-size:0.9rem; padding:8px 16px;">
            Save Changes
        </button>
    </div>

    <div class="clinic-info-list">
        <!-- Clinic Name -->
        <div class="clinic-info-item">
            <div class="clinic-icon-box">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h6M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>

            <div class="clinic-detail-content">
                <span class="clinic-detail-label">
                    Clinic Registered Name
                </span>

                <span class="clinic-detail-value">
                    <?php
                    echo htmlspecialchars($data['clinicInfo']['name']);
                    ?>
                </span>
            </div>
        </div>

        <!-- Address -->
        <div class="clinic-info-item">
            <div class="clinic-icon-box">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" >
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round"stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"  />
                </svg>
            </div>

            <div class="clinic-detail-content">
                <span class="clinic-detail-label">
                    Physical Location Address
                </span>
                <span class="clinic-detail-value">
                    <?php
                    echo htmlspecialchars($data['clinicInfo']['address']);
                    ?>
                </span>
            </div>
        </div>

        <!-- Phone -->
        <div class="clinic-info-item">
            <div class="clinic-icon-box">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" >
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H5a2 2 0 01-2-2V5z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H5a2 2 0 01-2-2v-2z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21a2 2 0 012-2h2a2 2 0 012 2v2H5a2 2 0 01-2-2v-2z" />
                </svg>
            </div>

            <div class="clinic-detail-content">
                <span class="clinic-detail-label">
                    Hotline & Phone Contacts
                </span>
                <span class="clinic-detail-value">
                    <?php
                    echo htmlspecialchars($data['clinicInfo']['phone']);
                    ?>
                </span>
            </div>
        </div>

        <!-- Email -->
        <div class="clinic-info-item">
            <div class="clinic-icon-box">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" >
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>

            <div class="clinic-detail-content">
                <span class="clinic-detail-label">
                    Official Contact Email
                </span>
                <span class="clinic-detail-value">
                    <?php
                    echo htmlspecialchars($data['clinicInfo']['email']);
                    ?>
                </span>
            </div>
        </div>

        <!-- Opening Hours -->
        <div class="clinic-info-item">
            <div class="clinic-icon-box">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 2"/>
                    <circle cx="12" cy="12" r="9" stroke-width="2" />
                </svg>

            </div>
            <div class="clinic-detail-content">
                <span class="clinic-detail-label">
                    Opening Hours
                </span>

                <span class="clinic-detail-value">
                    <?php
                    echo htmlspecialchars($data['clinicInfo']['hours']);
                    ?>
                </span>
            </div>
        </div>

        <!-- Emergency Phone -->
        <div class="clinic-info-item">
            <div class="clinic-icon-box">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" >
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                </svg>
            </div>

            <div class="clinic-detail-content">
                <span class="clinic-detail-label">
                    Emergency Contact
                </span>
                <span class="clinic-detail-value">
                    <?php
                    echo htmlspecialchars($data['clinicInfo']['emergency_phone']);
                    ?>
                </span>
            </div>
        </div>

        <!-- License -->
        <div class="clinic-info-item">
            <div class="clinic-icon-box">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 4h14a2 2 0 012 2v14H3V6a2 2 0 012-2z"/>
                </svg>
            </div>

            <div class="clinic-detail-content">
                <span class="clinic-detail-label">
                    Veterinary License Number
                </span>
                <span class="clinic-detail-value">
                    <?php
                    echo htmlspecialchars($data['clinicInfo']['license_no']);
                    ?>
                </span>
            </div>
        </div>
    </div>
</div>