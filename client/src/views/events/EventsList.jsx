// import { useState, useEffect } from 'react'

import { Link } from 'react-router-dom'
import { route } from '@/routes'
import { useEvents } from '@/hooks/useEvents'
import { useEvent } from '@/hooks/useEvent'

function EventsList() {
    const { events, getEvents } = useEvents()
    const { destroyEvent } = useEvent()

    return (
        <div className="">

            <h1 className="heading">Events</h1>

            <Link to={ route('events.create') } className="">
                Add Event
            </Link>

            <div className=""></div>

            <div className="">
                { events.length > 0 && events.map((event) => {
                return (
                    <div
                        key={ event.id }
                        className=""
                    >
                        <div className="">
                            { event.title }
                        </div>
                        <div className="">
                            { event.description }
                        </div>
                        <div className="">
                            { event.start_date } { event.start_time }
                        </div>
                        <div className="">
                            { event.end_date } { event.end_time }
                        </div>
                        <div className="">
                            <Link
                                to={ route('event-halls.edit', { id: event.event_hall.id }) }
                                className=""
                            >
                                { event.event_hall.name }
                            </Link>
                        </div>
                        <div className="">
                            <Link
                                to={ route('hosts.edit', { id: event.host.id }) }
                                className=""
                            >
                                { event.host.name }
                            </Link>
                        </div>
                        {/* <div className="">
                            <Link
                                to={ route('users.edit', { id: event.added_by.id }) }
                                className=""
                            >
                                { event.user.name }
                            </Link>
                        </div> */}

                        <div className="">
                            <Link
                                to={ route('events.edit', { id: event.id }) }
                                className=""
                            >
                                Edit
                            </Link>
                            <button
                                type="button"
                                className=""
                                onClick={ async () => {
                                    await destroyEvent(event)
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

export default EventsList
