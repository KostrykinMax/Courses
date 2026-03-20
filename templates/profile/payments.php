<?php
$payments = $payments ?? [];
?>

<div class="container" style="padding: 40px 20px;">
    <h1 style="margin-bottom: 40px;">История платежей</h1>
    
    <a href="<?php echo url('?page=profile'); ?>" class="btn btn-secondary" style="margin-bottom: 30px;">← Вернуться в личный кабинет</a>
    
    <?php if (!empty($payments)): ?>
        <div class="payments-list">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: var(--gray-100);">
                        <th style="padding: 15px; text-align: left;">Дата</th>
                        <th style="padding: 15px; text-align: left;">Курс</th>
                        <th style="padding: 15px; text-align: left;">Сумма</th>
                        <th style="padding: 15px; text-align: left;">Статус</th>
                        <th style="padding: 15px; text-align: left;">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($payments as $payment): ?>
                    <tr style="border-bottom: 1px solid var(--gray-200);">
                        <td style="padding: 15px;"><?php echo date('d.m.Y H:i', strtotime($payment['purchase_date'])); ?></td>
                        <td style="padding: 15px;"><?php echo htmlspecialchars($payment['course_title']); ?></td>
                        <td style="padding: 15px; font-weight: 600;"><?php echo number_format($payment['price'], 0, '.', ' '); ?> ₽</td>
                        <td style="padding: 15px;">
                            <?php if ($payment['payment_status'] == 'paid'): ?>
                            <span class="payment-status paid">Оплачено</span>
                            <?php elseif ($payment['payment_status'] == 'pending'): ?>
                            <span class="payment-status pending">В обработке</span>
                                <a href="#" class="btn btn-primary btn-sm" style="margin-left: 10px;">Оплатить</a>
                            <?php else: ?>
                            <span class="payment-status"><?php echo $payment['payment_status']; ?></span>
                            <?php endif; ?>
                        </td>
                        <td style="padding: 15px;">
                            <a href="#" class="btn btn-outline btn-sm">Чек</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div style="text-align: center; padding: 60px; background: var(--gray-100); border-radius: var(--border-radius);">
            <p style="font-size: 1.2rem; color: var(--gray-600); margin-bottom: 20px;">История платежей пуста</p>
            <a href="<?php echo url('?page=courses'); ?>" class="btn btn-primary">Выбрать курс</a>
        </div>
    <?php endif; ?>
</div>