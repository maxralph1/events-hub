import { Link, useParams } from 'react-router-dom'
import { route } from '@/routes'
import { useTicket } from '@/hooks/useTicket'
 
function Ticket() {
    const params = useParams()
    const { ticket } = useTicket(params.id)
    
    return (
        <div className="">
    
            <h1 className="">Ticket <b>{ ticket.data.ticket_number }</b></h1>

            <p>Ticket Number: { ticket.data.ticket_number }</p>

            <p>Amount Paid: { ticket.data.amount_paid } { ticket.data.currency.title }</p>
    
            {/* For admin eyes only */}
            <p>User: { ticket.data.user.name }</p>

            <p>Payment Confirmed: { ticket.data.payment_confirmed }</p>
            {/* end for admin eyes only */}
    
            <div className=""></div>
    
            <div className="">
                <Link to={ route('tickets.index') } className="">
                    All Tickets
                </Link>
            </div>
        </div>
    )
}
 
export default Ticket