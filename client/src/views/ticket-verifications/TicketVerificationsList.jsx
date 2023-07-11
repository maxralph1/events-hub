// import { useState, useEffect } from 'react'

import { Link } from 'react-router-dom'
import { route } from '@/routes'
import { useTicketVerifications } from '@/hooks/useTicketVerifications'
import { useTicketVerification } from '@/hooks/useTicketVerification'

function TicketVerificationsList() {
    const { ticketVerifications, getTicketVerifications } = useTicketVerifications()
    const { destroyTicketVerification } = useTicketVerification()

    return (
        <div className="">

            <h1 className="heading">Ticket Verifications</h1>

            <Link to={ route('ticket-verifications.create') } className="">
                Add TicketVerification
            </Link>

            <div className=""></div>

            <div className="">
                { ticketVerifications.length > 0 && ticketVerifications.map((ticketVerification) => {
                return (
                    <div
                        key={ ticketVerification.id }
                        className=""
                    >
                        <div className="">
                            { ticketVerification.title }
                        </div>
                        <div className="">
                            { ticketVerification.description }
                        </div>
                        <div className="">
                            { ticketVerification.available_tickets }
                        </div>
                        <div className="">
                            <Link
                                to={ route('ticket-verifications.edit', { id: ticketVerification.event.id }) }
                                className=""
                            >
                                { ticketVerification.event.name }
                            </Link>
                        </div>
                        <div className="">
                            <div className="">
                                { ticketVerification.price }
                            </div>
                            <Link
                                to={ route('currencies.edit', { id: ticketVerification.currency.id }) }
                                className=""
                            >
                                { ticketVerification.currency.title }
                            </Link>
                        </div>

                        <div className="">
                            <Link
                                to={ route('ticket-verifications.edit', { id: ticketVerification.id }) }
                                className=""
                            >
                                Edit
                            </Link>
                            <button
                                type="button"
                                className=""
                                onClick={ async () => {
                                    await destroyTicketVerification(ticketVerification)
                                    await getTicketVerifications()
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

export default TicketVerificationsList
