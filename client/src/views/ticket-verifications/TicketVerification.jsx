import { Link, useParams } from 'react-router-dom'
import { route } from '@/routes'
import { useTicketVerification } from '@/hooks/useTicketVerification'
 
function TicketVerification() {
    const params = useParams()
    const { ticketVerification } = useTicketVerification(params.id)
    
    return (
        <div className="">
    
            <h1 className="">TicketVerification <b>{ ticketVerification.data.title }</b></h1>

            <p>ID: { ticketVerification.data.id }</p>

            <p>Title: { ticketVerification.data.title }</p>
    
            <p>Description: { ticketVerification.data.description }</p>
    
            <p>Event: { ticketVerification.data.event.title }</p>
    
            <p>Price: { ticketVerification.data.currency.title } { ticketVerification.data.price }</p>
    
            <p>User: { ticketVerification.data.user.name }</p>
    
            <div className=""></div>
    
            <div className="">
                <Link to={ route('ticket-verifications.index') } className="">
                    All Ticket Types
                </Link>
            </div>
        </div>
    )
}
 
export default TicketVerification