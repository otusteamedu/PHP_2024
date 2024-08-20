

const PartnerUserWithdraw = () => {

    return (
        <>
            <div className="page_head">

                <div className="log_head_title">

                    <h2>Вывод средств</h2>

                </div>

            </div>

            <div className="partner_with_body">

                <div className="p_w_b_block">

                    <div className="p_w_b_bl_header"><p>Вывод средств осуществляется в Tether TRC20</p></div>

                    <div className="p_w_b_bl_inputs">

                        <div className="p_w_b_bl_i_row">
                            <span>163.8</span>
                            <div className="p_w_b_bl_i_r_cur"><span>USDT</span></div>
                        </div>

                        <input aria-label="USDT address" type="text" className="p_w_b_bl_i_row"
                               placeholder="Address Tether TRC20" />

                    </div>

                    <button type="submit" className="yellow_btn"><span>Вывести</span></button>

                </div>

            </div>
        </>
    )

}

export default PartnerUserWithdraw;