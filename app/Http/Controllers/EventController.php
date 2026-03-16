<?php

namespace App\Http\Controllers;

use App\Actions\CreateEvent;
use App\Actions\UpdateEvent;
use App\EventStatus;
use App\Http\Requests\EventRequest;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {

        if ($request->routeIs('admin.events.index')) {
            $eventStatus = EventStatus::AWAITING;
            if ($request->status) {
                if ($request->status === 'awaiting') {
                    $events = Event::where('display_starts_at', '>', now())
                        ->latest()
                        ->get();
                } elseif ($request->status === 'in_effect') {
                    $eventStatus = EventStatus::IN_EFFECT;
                    $events = Event::where('display_starts_at', '<=', now())
                        ->where('display_ends_at', '>=', now())
                        ->latest()
                        ->get();
                } elseif ($request->status === 'completed') {
                    $eventStatus = EventStatus::COMPLETED;
                    $events = Event::where('display_ends_at', '<', now())
                        ->latest()
                        ->get();
                } else {
                    $events = Event::latest()->get();
                }
            } else {
                $events = Event::latest()->get();
            }

            return view('admin.index', [
                'events' => $events,
                'status' => $eventStatus,
                'statusCounts' => Event::statusCounts(),
            ]);
        }

        $events = Event::where('display_starts_at', '<=', now())
            ->where('display_ends_at', '>=', now())
            ->latest()
            ->get();

        return view('home', [
            'events' => $events,
            'statusCounts' => Event::statusCounts(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): void
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EventRequest $request, CreateEvent $action)
    {
        $action->handle($request->safe()->all());

        return to_route('admin.events.index')
            ->with('success', __('Event created successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        return view('events.show', [
            'event' => $event,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EventRequest $request, Event $event, UpdateEvent $action)
    {
        $action->handle($request->safe()->all(), $event);

        return back()->with('success', __('Event updated!'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $event->delete();

        return to_route('admin.events.index');
    }

    public function tv()
    {
        $events = Event::where('display_starts_at', '<=', now())
            ->where('display_ends_at', '>=', now())
            ->latest()
            ->get();

        return view('tv', [
            'events' => $events,
            'statusCounts' => Event::statusCounts(),
        ]);
    }
}
