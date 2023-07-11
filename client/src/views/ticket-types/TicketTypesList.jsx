// import { useState, useEffect } from 'react'

import { Link } from 'react-router-dom'
import { route } from '@/routes'
import { useTicketTypes } from '@/hooks/useTicketTypes'
import { useTicketType } from '@/hooks/useTicketType'

function TicketTypesList() {
    const { ticketTypes, getTicketTypes } = useTicketTypes()
    const { destroyTicketType } = useTicketType()

    return (
        <div className="">

            <h1 className="heading">TicketTypes</h1>

            <Link to={ route('ticket-types.create') } className="">
                Add TicketType
            </Link>

            <div className=""></div>

            <div className="">
                { ticketTypes.length > 0 && ticketTypes.map((ticketType) => {
                return (
                    <div
                        key={ ticketType.id }
                        className=""
                    >
                        <div className="">
                            { ticketType.title }
                        </div>
                        <div className="">
                            { ticketType.description }
                        </div>
                        <div className="">
                            { ticketType.available_tickets }
                        </div>
                        <div className="">
                            <Link
                                to={ route('ticket-types.edit', { id: ticketType.event.id }) }
                                className=""
                            >
                                { ticketType.event.name }
                            </Link>
                        </div>
                        <div className="">
                            <div className="">
                                { ticketType.price }
                            </div>
                            <Link
                                to={ route('currencies.edit', { id: ticketType.currency.id }) }
                                className=""
                            >
                                { ticketType.currency.title }
                            </Link>
                        </div>

                        <div className="">
                            <Link
                                to={ route('ticket-types.edit', { id: ticketType.id }) }
                                className=""
                            >
                                Edit
                            </Link>
                            <button
                                type="button"
                                className=""
                                onClick={ async () => {
                                    await destroyEvent(ticketType)
                                    await getEvents()
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

export default TicketTypesList
