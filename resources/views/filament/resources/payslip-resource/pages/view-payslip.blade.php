<x-filament-panels::page>
    <div class="payslip-container">
        
        <div class="employee-details">
            <p><strong>Employee Name:</strong> {{ $user->name }}</p>
        </div>
        
        <table class="payslip-table">
            <thead>
                <tr>
                    <th>Earnings</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Total Regular Hours</td>
                    <td>{{ $regularHours }} hours</td>
                </tr>
                <tr>
                    <td>Hourly Rate</td>
                    <td>Php {{ $employee->salary->hourly_rate }}</td>
                </tr>
                <tr>
                    <td>Regular Pay</td>
                    <td>Php {{ number_format($regularPay, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td>Overtime Hours</td>
                    <td>{{ $overtimeHours }} hours</td>
                </tr>
                <tr>
                    <td>Overtime Rate</td>
                    <td>Php {{ $employee->salary->ot_rate }}</td>
                </tr>
                <tr>
                    <td>Overtime Pay</td>
                    <td>Php {{ number_format($overtimePay, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td>Gross Pay (Regular Pay + Overtime Pay)</td>
                    <td>Php {{ number_format($grossPay, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td colspan="2"><strong>Deductions</strong></td>
                </tr>
                <tr>
                    <td>BIR</td>
                    <td>Php {{ $employee->salary->bir }}</td>
                </tr>
                <tr>
                    <td>SSS</td>
                    <td>Php {{ $employee->salary->sss }}</td>
                </tr>
                <tr>
                    <td>Philhealth</td>
                    <td>Php {{ $employee->salary->philhealth }}</td>
                </tr>
                <tr>
                    <td>Pagibig</td>
                    <td>Php {{ $employee->salary->pagibig }}</td>
                </tr>
                <tr>
                    <td>Total Deductions</td>
                    <td>Php {{ number_format($deductions, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td>Non-Taxable Allowance</td>
                    <td>Php {{ number_format($allowance, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td><strong>Total Net Income</strong></td>
                    <td><strong>Php {{ number_format($netPay, 2) }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>

<style>
.payslip-container {
    padding: 20px;
    background: #fff;
    border: 1px solid #ccc;
    border-radius: 5px;
    max-width: 600px;
    margin: auto;
}

.payslip-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.payslip-table th, .payslip-table td {
    border: 1px solid #ccc;
    padding: 10px;
    text-align: left;
}
</style>

</x-filament-panels::page>
