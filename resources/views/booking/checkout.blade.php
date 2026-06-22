<x-app-layout>
    <x-slot name="title">Book — {{ $course->title }} | IFS Nigeria</x-slot>

    {{-- Page Header --}}
    <section style="background:linear-gradient(135deg,#0F2E3A,#1A4D5E);padding:2rem 1.5rem;color:white;">
        <div style="max-width:1200px;margin:0 auto;">
            @if($course->category)
                <span style="background:#E07B2A;color:white;font-size:0.7rem;font-weight:700;padding:0.2rem 0.6rem;border-radius:999px;margin-bottom:0.5rem;display:inline-block;">{{ $course->category->name }}</span>
            @endif
            <h1 style="font-size:1.5rem;font-weight:800;margin:0.25rem 0 0;font-family:Georgia,serif;">Book: {{ $course->title }}</h1>
            <p style="font-size:0.85rem;color:rgba(255,255,255,0.7);margin:0.25rem 0 0;">Complete your booking below — no account required</p>
        </div>
    </section>

    <div style="max-width:1200px;margin:0 auto;padding:2rem 1.5rem;">

        @if($errors->any())
            <div style="background:#FEF2F2;border:1px solid #FCA5A5;border-radius:0.5rem;padding:1rem 1.25rem;margin-bottom:1.5rem;">
                <p style="font-weight:600;color:#DC2626;margin:0 0 0.5rem;font-size:0.875rem;">Please fix the following errors:</p>
                <ul style="margin:0;padding-left:1.25rem;color:#B91C1C;font-size:0.85rem;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('booking.process', $course->slug) }}"
            x-data="{
                bookerType: '{{ old('booker_type','individual') }}',
                delegates: {{ old('number_of_delegates', 1) }},
                pricePerPerson: {{ (float)($course->price ?? 0) }},
                paymentMethod: '{{ old('payment_method','paystack') }}',
                delegateNames: @json(old('delegate_names', [])),
                selectedScheduleId: '{{ old('schedule_id', $preselectedSchedule?->id ?? '') }}',
                selectedScheduleText: '',
                get subtotal() { return this.delegates * this.pricePerPerson },
                get vat() { return this.subtotal * 0.075 },
                get total() { return this.subtotal + this.vat },
                formatNGN(v) { return '₦' + Number(v).toLocaleString('en-NG', {minimumFractionDigits:0}) },
                addDelegate() { this.delegateNames.push({name: '', email: ''}) },
                removeDelegate(i) { this.delegateNames.splice(i, 1) }
            }"
            style="display:grid;grid-template-columns:1fr 360px;gap:2rem;align-items:start;">

            @csrf

            {{-- ── Left Column ─────────────────────────────────────────────────── --}}
            <div>

                {{-- Step 1: Booker Type --}}
                <div style="background:white;border:1px solid #DDE3EA;border-radius:0.75rem;padding:1.5rem;margin-bottom:1.25rem;">
                    <h2 style="font-size:1rem;font-weight:700;color:#0F1F2B;margin:0 0 1rem;display:flex;align-items:center;gap:0.5rem;">
                        <span style="background:#1A4D5E;color:white;width:24px;height:24px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;font-size:0.75rem;font-weight:800;flex-shrink:0;">1</span>
                        Booking Type
                    </h2>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.75rem;">
                        <label style="cursor:pointer;">
                            <input type="radio" name="booker_type" value="individual" x-model="bookerType" style="display:none;">
                            <div :style="bookerType==='individual'
                                ? 'border:2px solid #1A4D5E;background:#F0F7FA;border-radius:0.5rem;padding:1rem;text-align:center;'
                                : 'border:2px solid #DDE3EA;border-radius:0.5rem;padding:1rem;text-align:center;'"
                                style="transition:all 0.15s;">
                                <div style="font-size:1.5rem;margin-bottom:0.25rem;">👤</div>
                                <p style="font-weight:700;color:#0F1F2B;margin:0;font-size:0.875rem;">Individual</p>
                                <p style="font-size:0.75rem;color:#6B7C8D;margin:0.25rem 0 0;">Booking for yourself</p>
                            </div>
                        </label>
                        <label style="cursor:pointer;">
                            <input type="radio" name="booker_type" value="company" x-model="bookerType" style="display:none;">
                            <div :style="bookerType==='company'
                                ? 'border:2px solid #1A4D5E;background:#F0F7FA;border-radius:0.5rem;padding:1rem;text-align:center;'
                                : 'border:2px solid #DDE3EA;border-radius:0.5rem;padding:1rem;text-align:center;'"
                                style="transition:all 0.15s;">
                                <div style="font-size:1.5rem;margin-bottom:0.25rem;">🏢</div>
                                <p style="font-weight:700;color:#0F1F2B;margin:0;font-size:0.875rem;">Corporate</p>
                                <p style="font-size:0.75rem;color:#6B7C8D;margin:0.25rem 0 0;">Booking for your company</p>
                            </div>
                        </label>
                    </div>
                </div>

                {{-- Step 2: Contact Details --}}
                <div style="background:white;border:1px solid #DDE3EA;border-radius:0.75rem;padding:1.5rem;margin-bottom:1.25rem;">
                    <h2 style="font-size:1rem;font-weight:700;color:#0F1F2B;margin:0 0 1rem;display:flex;align-items:center;gap:0.5rem;">
                        <span style="background:#1A4D5E;color:white;width:24px;height:24px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;font-size:0.75rem;font-weight:800;flex-shrink:0;">2</span>
                        Contact Details
                    </h2>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                        <div>
                            <label style="font-size:0.8rem;font-weight:600;color:#374151;display:block;margin-bottom:0.35rem;">Contact Person <span style="color:#DC2626;">*</span></label>
                            <input type="text" name="contact_person" value="{{ old('contact_person') }}" placeholder="Full name"
                                style="width:100%;padding:0.6rem 0.75rem;border:1px solid #DDE3EA;border-radius:0.4rem;font-size:0.875rem;box-sizing:border-box;outline:none;" required>
                        </div>
                        <div>
                            <label style="font-size:0.8rem;font-weight:600;color:#374151;display:block;margin-bottom:0.35rem;">Email Address <span style="color:#DC2626;">*</span></label>
                            <input type="email" name="contact_email" value="{{ old('contact_email') }}" placeholder="email@example.com"
                                style="width:100%;padding:0.6rem 0.75rem;border:1px solid #DDE3EA;border-radius:0.4rem;font-size:0.875rem;box-sizing:border-box;outline:none;" required>
                        </div>
                        <div>
                            <label style="font-size:0.8rem;font-weight:600;color:#374151;display:block;margin-bottom:0.35rem;">Phone Number <span style="color:#DC2626;">*</span></label>
                            <input type="tel" name="contact_phone" value="{{ old('contact_phone') }}" placeholder="+234 800 000 0000"
                                style="width:100%;padding:0.6rem 0.75rem;border:1px solid #DDE3EA;border-radius:0.4rem;font-size:0.875rem;box-sizing:border-box;outline:none;" required>
                        </div>
                        {{-- Company fields --}}
                        <div x-show="bookerType==='company'" x-transition>
                            <label style="font-size:0.8rem;font-weight:600;color:#374151;display:block;margin-bottom:0.35rem;">Company Name <span style="color:#DC2626;">*</span></label>
                            <input type="text" name="company_name" value="{{ old('company_name') }}" placeholder="Company Ltd."
                                :required="bookerType==='company'"
                                style="width:100%;padding:0.6rem 0.75rem;border:1px solid #DDE3EA;border-radius:0.4rem;font-size:0.875rem;box-sizing:border-box;outline:none;">
                        </div>
                    </div>
                    <div x-show="bookerType==='company'" x-transition style="margin-top:1rem;display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                        <div>
                            <label style="font-size:0.8rem;font-weight:600;color:#374151;display:block;margin-bottom:0.35rem;">Company Address</label>
                            <input type="text" name="company_address" value="{{ old('company_address') }}" placeholder="Lagos, Nigeria"
                                style="width:100%;padding:0.6rem 0.75rem;border:1px solid #DDE3EA;border-radius:0.4rem;font-size:0.875rem;box-sizing:border-box;outline:none;">
                        </div>
                        <div>
                            <label style="font-size:0.8rem;font-weight:600;color:#374151;display:block;margin-bottom:0.35rem;">PO Number (Optional)</label>
                            <input type="text" name="po_number" value="{{ old('po_number') }}" placeholder="PO-2024-001"
                                style="width:100%;padding:0.6rem 0.75rem;border:1px solid #DDE3EA;border-radius:0.4rem;font-size:0.875rem;box-sizing:border-box;outline:none;">
                        </div>
                    </div>
                </div>

                {{-- Step 3: Booking Details --}}
                <div style="background:white;border:1px solid #DDE3EA;border-radius:0.75rem;padding:1.5rem;margin-bottom:1.25rem;">
                    <h2 style="font-size:1rem;font-weight:700;color:#0F1F2B;margin:0 0 1rem;display:flex;align-items:center;gap:0.5rem;">
                        <span style="background:#1A4D5E;color:white;width:24px;height:24px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;font-size:0.75rem;font-weight:800;flex-shrink:0;">3</span>
                        Booking Details
                    </h2>

                    {{-- Course locked --}}
                    <div style="background:#F5F7F9;border:1px solid #DDE3EA;border-radius:0.5rem;padding:0.75rem 1rem;margin-bottom:1rem;display:flex;align-items:center;gap:0.75rem;">
                        <div style="width:40px;height:40px;background:linear-gradient(135deg,#1A4D5E,#2a7a8e);border-radius:0.4rem;flex-shrink:0;"></div>
                        <div>
                            <p style="font-weight:700;color:#0F1F2B;margin:0;font-size:0.875rem;">{{ $course->title }}</p>
                            <p style="font-size:0.75rem;color:#6B7C8D;margin:0;">{{ $course->duration_days }} day(s) · {{ ucfirst($course->mode ?? 'virtual') }}</p>
                        </div>
                    </div>

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                        <div>
                            <label style="font-size:0.8rem;font-weight:600;color:#374151;display:block;margin-bottom:0.35rem;">Training Date <span style="color:#DC2626;">*</span></label>
                            <select name="schedule_id" x-model="selectedScheduleId" required
                                style="width:100%;padding:0.6rem 0.75rem;border:1px solid #DDE3EA;border-radius:0.4rem;font-size:0.875rem;box-sizing:border-box;outline:none;background:white;">
                                <option value="">— Select a date —</option>
                                @foreach($course->schedules as $schedule)
                                    <option value="{{ $schedule->id }}" {{ old('schedule_id', $preselectedSchedule?->id) == $schedule->id ? 'selected' : '' }}>
                                        {{ $schedule->start_date->format('d M Y') }} – {{ $schedule->end_date->format('d M Y') }}
                                        @if($schedule->venue) · {{ $schedule->venue }} @endif
                                    </option>
                                @endforeach
                            </select>
                            @if($course->schedules->isEmpty())
                                <p style="font-size:0.75rem;color:#E07B2A;margin:0.35rem 0 0;">No open schedules — <a href="mailto:info@ifsnigeria.com" style="color:#1A4D5E;">contact us</a> to arrange.</p>
                            @endif
                        </div>
                        <div>
                            <label style="font-size:0.8rem;font-weight:600;color:#374151;display:block;margin-bottom:0.35rem;">Number of Delegates <span style="color:#DC2626;">*</span></label>
                            <input type="number" name="number_of_delegates" x-model.number="delegates" min="1" max="100" value="{{ old('number_of_delegates', 1) }}"
                                style="width:100%;padding:0.6rem 0.75rem;border:1px solid #DDE3EA;border-radius:0.4rem;font-size:0.875rem;box-sizing:border-box;outline:none;" required>
                        </div>
                    </div>
                </div>

                {{-- Step 4: Delegate Names (optional) --}}
                <div style="background:white;border:1px solid #DDE3EA;border-radius:0.75rem;padding:1.5rem;margin-bottom:1.25rem;">
                    <h2 style="font-size:1rem;font-weight:700;color:#0F1F2B;margin:0 0 0.25rem;display:flex;align-items:center;gap:0.5rem;">
                        <span style="background:#1A4D5E;color:white;width:24px;height:24px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;font-size:0.75rem;font-weight:800;flex-shrink:0;">4</span>
                        Delegate Names
                        <span style="font-size:0.7rem;font-weight:500;color:#6B7C8D;background:#F5F7F9;border:1px solid #DDE3EA;padding:0.1rem 0.4rem;border-radius:999px;">Optional</span>
                    </h2>
                    <p style="font-size:0.8rem;color:#6B7C8D;margin:0 0 1rem;">Add delegate names and emails for certificates and joining instructions.</p>

                    <template x-for="(delegate, i) in delegateNames" :key="i">
                        <div style="display:grid;grid-template-columns:1fr 1fr auto;gap:0.75rem;margin-bottom:0.75rem;align-items:end;">
                            <div>
                                <label style="font-size:0.75rem;font-weight:600;color:#374151;display:block;margin-bottom:0.25rem;" :for="'dn_name_'+i">Name</label>
                                <input :id="'dn_name_'+i" type="text" :name="'delegate_names['+i+'][name]'" x-model="delegate.name" placeholder="Delegate name"
                                    style="width:100%;padding:0.5rem 0.6rem;border:1px solid #DDE3EA;border-radius:0.4rem;font-size:0.8rem;box-sizing:border-box;">
                            </div>
                            <div>
                                <label style="font-size:0.75rem;font-weight:600;color:#374151;display:block;margin-bottom:0.25rem;" :for="'dn_email_'+i">Email</label>
                                <input :id="'dn_email_'+i" type="email" :name="'delegate_names['+i+'][email]'" x-model="delegate.email" placeholder="delegate@company.com"
                                    style="width:100%;padding:0.5rem 0.6rem;border:1px solid #DDE3EA;border-radius:0.4rem;font-size:0.8rem;box-sizing:border-box;">
                            </div>
                            <button type="button" @click="removeDelegate(i)"
                                style="padding:0.5rem 0.6rem;background:#FEF2F2;border:1px solid #FCA5A5;border-radius:0.4rem;color:#DC2626;cursor:pointer;font-size:0.8rem;white-space:nowrap;">
                                Remove
                            </button>
                        </div>
                    </template>

                    <button type="button" @click="addDelegate()"
                        style="background:#F0F7FA;border:1px dashed #1A4D5E;color:#1A4D5E;font-weight:600;padding:0.6rem 1rem;border-radius:0.4rem;cursor:pointer;font-size:0.8rem;width:100%;text-align:center;">
                        + Add Delegate
                    </button>
                </div>

                {{-- Step 5: Payment Method --}}
                <div style="background:white;border:1px solid #DDE3EA;border-radius:0.75rem;padding:1.5rem;margin-bottom:1.5rem;">
                    <h2 style="font-size:1rem;font-weight:700;color:#0F1F2B;margin:0 0 1rem;display:flex;align-items:center;gap:0.5rem;">
                        <span style="background:#1A4D5E;color:white;width:24px;height:24px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;font-size:0.75rem;font-weight:800;flex-shrink:0;">5</span>
                        Payment Method
                    </h2>
                    <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:0.75rem;">
                        @foreach([['paystack','💳','Paystack','Card, Bank Transfer'],['flutterwave','⚡','Flutterwave','Card, USSD, Mobile'],['invoice','🧾','Invoice','Pay by Bank Transfer']] as $pm)
                        <label style="cursor:pointer;">
                            <input type="radio" name="payment_method" value="{{ $pm[0] }}" x-model="paymentMethod" style="display:none;">
                            <div :style="paymentMethod==='{{ $pm[0] }}'
                                ? 'border:2px solid #1A4D5E;background:#F0F7FA;border-radius:0.5rem;padding:1rem;text-align:center;'
                                : 'border:2px solid #DDE3EA;border-radius:0.5rem;padding:1rem;text-align:center;'"
                                style="transition:all 0.15s;">
                                <p style="font-size:1.25rem;margin:0 0 0.25rem;">{{ $pm[1] }}</p>
                                <p style="font-weight:700;color:#0F1F2B;margin:0;font-size:0.8rem;">{{ $pm[2] }}</p>
                                <p style="font-size:0.7rem;color:#6B7C8D;margin:0.2rem 0 0;line-height:1.3;">{{ $pm[3] }}</p>
                            </div>
                        </label>
                        @endforeach
                    </div>
                    <div x-show="paymentMethod==='invoice'" x-transition style="margin-top:1rem;background:#FFFBEB;border:1px solid #FDE68A;border-radius:0.4rem;padding:0.75rem;font-size:0.8rem;color:#92400E;">
                        An invoice will be sent to your email. Payment is due within 14 business days.
                    </div>
                </div>

                <button type="submit"
                    style="width:100%;background:linear-gradient(135deg,#1A4D5E,#2a6b80);color:white;font-weight:700;font-size:1rem;padding:1rem;border:none;border-radius:0.5rem;cursor:pointer;letter-spacing:0.02em;transition:opacity 0.15s;"
                    onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                    Complete Booking
                </button>

                <p style="font-size:0.75rem;color:#6B7C8D;text-align:center;margin:0.75rem 0 0;">
                    By booking you agree to our <a href="#" style="color:#1A4D5E;">Terms & Conditions</a> and <a href="#" style="color:#1A4D5E;">Privacy Policy</a>.
                </p>

            </div>{{-- /left --}}

            {{-- ── Right Column: Order Summary ─────────────────────────────────── --}}
            <div style="position:sticky;top:80px;align-self:start;">
                <div style="background:white;border:1px solid #DDE3EA;border-radius:0.75rem;overflow:hidden;">
                    <div style="background:linear-gradient(135deg,#1A4D5E,#0F2E3A);padding:1.25rem 1.5rem;">
                        <h3 style="color:white;font-weight:700;font-size:1rem;margin:0;font-family:Georgia,serif;">Order Summary</h3>
                    </div>
                    <div style="padding:1.25rem 1.5rem;">
                        <p style="font-weight:700;color:#0F1F2B;font-size:0.9rem;margin:0 0 0.25rem;">{{ $course->title }}</p>
                        @if($course->category)
                            <span style="font-size:0.7rem;color:white;background:#E07B2A;padding:0.15rem 0.5rem;border-radius:999px;font-weight:600;">{{ $course->category->name }}</span>
                        @endif

                        <div style="border-top:1px solid #DDE3EA;margin:1rem 0;padding-top:1rem;">
                            <div style="display:flex;justify-content:space-between;font-size:0.8rem;margin-bottom:0.5rem;">
                                <span style="color:#6B7C8D;">Price per delegate</span>
                                <span style="color:#0F1F2B;font-weight:600;">₦{{ number_format($course->price ?? 0) }}</span>
                            </div>
                            <div style="display:flex;justify-content:space-between;font-size:0.8rem;margin-bottom:0.5rem;">
                                <span style="color:#6B7C8D;">Delegates</span>
                                <span style="color:#0F1F2B;font-weight:600;" x-text="delegates"></span>
                            </div>
                            <div style="display:flex;justify-content:space-between;font-size:0.8rem;margin-bottom:0.5rem;">
                                <span style="color:#6B7C8D;">Subtotal</span>
                                <span style="color:#0F1F2B;font-weight:600;" x-text="formatNGN(subtotal)"></span>
                            </div>
                            <div style="display:flex;justify-content:space-between;font-size:0.8rem;margin-bottom:0.75rem;">
                                <span style="color:#6B7C8D;">VAT (7.5%)</span>
                                <span style="color:#0F1F2B;font-weight:600;" x-text="formatNGN(vat)"></span>
                            </div>
                            <div style="display:flex;justify-content:space-between;padding:0.75rem;background:#F0F7FA;border-radius:0.4rem;border:1px solid #C7E3EC;">
                                <span style="font-weight:700;color:#0F1F2B;">Total</span>
                                <span style="font-weight:800;color:#1A4D5E;font-size:1.1rem;" x-text="formatNGN(total)"></span>
                            </div>
                        </div>

                        <div style="font-size:0.75rem;color:#6B7C8D;line-height:1.6;">
                            <p style="margin:0 0 0.25rem;">✅ Instant booking confirmation</p>
                            <p style="margin:0 0 0.25rem;">📧 Email joining instructions</p>
                            <p style="margin:0;">🏆 Certificate upon completion</p>
                        </div>

                        <div style="margin-top:1rem;padding:0.75rem;background:#F5F7F9;border-radius:0.4rem;font-size:0.75rem;color:#6B7C8D;text-align:center;">
                            Questions? <a href="mailto:info@ifsnigeria.com" style="color:#1A4D5E;font-weight:600;">info@ifsnigeria.com</a><br>
                            +234 800 IFS TRAIN
                        </div>
                    </div>
                </div>
            </div>{{-- /right --}}

        </form>
    </div>

</x-app-layout>
