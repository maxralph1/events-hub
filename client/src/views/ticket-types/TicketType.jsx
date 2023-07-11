import { Link, useParams } from 'react-router-dom'
import { route } from '@/routes'
import { useTicketType } from '@/hooks/useTicketType'
 
function TicketType() {
    const params = useParams()
    const { ticketType } = useTicketType(params.id)
    
    return (
        <div className="">
    
            <h1 className="">TicketType <b>{ ticketType.data.title }</b></h1>

            <p>ID: { ticketType.data.id }</p>

            <p>Title: { ticketType.data.title }</p>
    
            <p>Description: { ticketType.data.description }</p>
    
            <p>Event: { ticketType.data.event.title }</p>
    
            <p>Price: { ticketType.data.currency.title } { ticketType.data.price }</p>
    
            <p>User: { ticketType.data.user.name }</p>
    
            <div className=""></div>
    
            <div className="">
                <Link to={ route('ticket-types.index') } className="">
                    All Ticket Types
                </Link>
            </div>
        </div>
    )
}
 
export default TicketType