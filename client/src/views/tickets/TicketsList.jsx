import { Link } from 'react-router-dom'
import { route } from '@/routes'
import { useTickets } from '@/hooks/useTickets'
import { useTicket } from '@/hooks/useTicket'

function TicketsList() {
    const { tickets, getTickets } = useTickets()
    const { destroyTicket } = useTicket()

    return (
        <div className="">

            <h1 className="heading">Tickets</h1>

            <Link to={ route('tickets.create') } className="">
                Add Ticket
            </Link>

            <div className=""></div>

            <div className="">
                { tickets.length > 0 && tickets.map((ticket) => {
                return (
                    <div
                        key={ ticket.id }
                        className=""
                    >
                        <div className="">
                            { ticket.ticket_number }
                        </div>
                        <div className="">
                            { ticket.amount_paid } { ticket.currency.title }
                        </div>

                        {/* for admin eyes only */}
                        <div className="">
                            <Link
                                to={ route('users.edit', { id: ticket.user.id }) }
                                className=""
                            >
                                { ticket.user.name }
                            </Link>
                        </div>
                        <div className="">
                            { ticket.payment_confirmed }
                        </div>
                        {/* end for admin eyes only */}

                        
                        <div className="">
                            <Link
                                to={ route('ticket-types.edit', { id: ticket.ticket_type.id }) }
                                className=""
                            >
                                { ticket.ticket_type.name }
                            </Link>
                        </div>

                        
                        <div className="">
                            <Link
                                to={ route('events.edit', { id: ticket.event.id }) }
                                className=""
                            >
                                { ticket.event.title }
                            </Link>
                        </div>

                        <div className="">
                            <Link
                                to={ route('tickets.edit', { id: ticket.id }) }
                                className=""
                            >
                                Edit
                            </Link>
                            <button
                                type="button"
                                className=""
                                onClick={ async () => {
                                    await destroyTicket(ticket)
                                    await getTickets()
                                } }
                            >
                            X
                            </button>
                        </div>
                    </div>
                    )
                })}
            </div>
        </div>
    )
}

export default TicketsList
