import { useState } from "react";
import {
  ArrowRight,
  Bell,
  BookOpen,
  CalendarDays,
  ChevronRight,
  CircleHelp,
  Clock3,
  Compass,
  Flame,
  GraduationCap,
  LayoutDashboard,
  Menu,
  MessageCircleMore,
  Play,
  Search,
  Send,
  Sparkles,
  Target,
  Trophy,
  X,
} from "lucide-react";

const navItems = [
  { label: "Overview", icon: LayoutDashboard },
  { label: "My courses", icon: BookOpen },
  { label: "Explore", icon: Compass },
  { label: "Calendar", icon: CalendarDays },
];

const courses = [
  {
    title: "The science of everyday life",
    subject: "Science",
    progress: 68,
    lesson: "Energy all around us",
    meta: "Lesson 8 of 12",
    tone: "coral",
    mark: "E = mc²",
  },
  {
    title: "Stories that shaped the world",
    subject: "Literature",
    progress: 42,
    lesson: "The art of the short story",
    meta: "Lesson 5 of 14",
    tone: "blue",
    mark: "Aa",
  },
  {
    title: "Thinking with numbers",
    subject: "Mathematics",
    progress: 81,
    lesson: "Patterns and sequences",
    meta: "Lesson 10 of 12",
    tone: "green",
    mark: "∑",
  },
];

const tasks = [
  { date: "24", month: "AUG", title: "Energy and motion quiz", course: "Everyday Science", kind: "Quiz", time: "Tomorrow" },
  { date: "27", month: "AUG", title: "Write your own short story", course: "World Literature", kind: "Assignment", time: "4 days" },
  { date: "30", month: "AUG", title: "Sequences practice set", course: "Thinking with Numbers", kind: "Practice", time: "7 days" },
];

function App() {
  const [activeNav, setActiveNav] = useState("Overview");
  const [menuOpen, setMenuOpen] = useState(false);
  const [tutorOpen, setTutorOpen] = useState(false);
  const [question, setQuestion] = useState("");
  const [tutorMessage, setTutorMessage] = useState("What are you curious about today?");

  function askTutor() {
    const trimmedQuestion = question.trim();
    if (!trimmedQuestion) return;
    setTutorMessage(`I’ll help you work through “${trimmedQuestion}” using your course material.`);
    setQuestion("");
  }

  return (
    <div className="app-shell">
      <aside className={`sidebar ${menuOpen ? "sidebar-open" : ""}`}>
        <div className="brand">
          <div className="brand-mark"><GraduationCap size={23} strokeWidth={2.2} /></div>
          <div><strong>Learning</strong><span>Website</span></div>
        </div>

        <button className="close-menu" onClick={() => setMenuOpen(false)} aria-label="Close navigation">
          <X size={20} />
        </button>

        <nav aria-label="Main navigation">
          <p className="nav-label">LEARN</p>
          {navItems.map(({ label, icon: Icon }) => (
            <button
              className={`nav-item ${activeNav === label ? "active" : ""}`}
              key={label}
              onClick={() => { setActiveNav(label); setMenuOpen(false); }}
            >
              <Icon size={19} />
              <span>{label}</span>
              {activeNav === label && <span className="active-dot" />}
            </button>
          ))}
        </nav>

        <div className="sidebar-bottom">
          <div className="streak-card">
            <div className="streak-icon"><Flame size={20} fill="currentColor" /></div>
            <div><strong>7 day streak</strong><span>Keep your spark alive</span></div>
          </div>
          <button className="nav-item"><CircleHelp size={19} /><span>Help center</span></button>
          <div className="profile-mini">
            <div className="avatar">OZ</div>
            <div><strong>Omar Zedan</strong><span>Student</span></div>
            <ChevronRight size={17} />
          </div>
        </div>
      </aside>

      {menuOpen && <button className="sidebar-scrim" onClick={() => setMenuOpen(false)} aria-label="Close navigation" />}

      <main>
        <header className="topbar">
          <button className="menu-button" onClick={() => setMenuOpen(true)} aria-label="Open navigation"><Menu /></button>
          <div className="mobile-brand">Learning Website</div>
          <label className="search-box">
            <Search size={18} />
            <input placeholder="Search your courses" aria-label="Search your courses" />
            <kbd>⌘ K</kbd>
          </label>
          <button className="icon-button" aria-label="Notifications"><Bell size={20} /><span className="notification-dot" /></button>
        </header>

        <div className="page-content">
          <section className="welcome-row reveal">
            <div>
              <p className="eyebrow">SATURDAY, AUGUST 22</p>
              <h1>Good afternoon, Omar.</h1>
              <p>You’re making real progress. Let’s keep the momentum going.</p>
            </div>
            <div className="weekly-goal">
              <div className="goal-ring"><span>4</span><small>/ 5</small></div>
              <div><span>WEEKLY GOAL</span><strong>One lesson to go</strong></div>
            </div>
          </section>

          <section className="hero-card reveal delay-1">
            <div className="hero-copy">
              <span className="pill"><Play size={12} fill="currentColor" /> CONTINUE LEARNING</span>
              <h2>Energy all around us</h2>
              <p>The science of everyday life</p>
              <div className="hero-progress"><span style={{ width: "68%" }} /></div>
              <div className="hero-meta"><span>68% complete</span><span><Clock3 size={14} /> 18 min left</span></div>
              <button className="primary-button">Resume lesson <ArrowRight size={17} /></button>
            </div>
            <div className="hero-art" aria-hidden="true">
              <div className="orbit orbit-one" /><div className="orbit orbit-two" />
              <div className="sun"><Sparkles size={34} /></div>
              <div className="planet planet-one" /><div className="planet planet-two" />
            </div>
          </section>

          <div className="dashboard-grid">
            <section className="courses-section reveal delay-2">
              <div className="section-heading">
                <div><p className="eyebrow">KEEP EXPLORING</p><h2>Your courses</h2></div>
                <button>View all <ArrowRight size={15} /></button>
              </div>
              <div className="course-grid">
                {courses.map((course) => (
                  <article className="course-card" key={course.title}>
                    <div className={`course-art ${course.tone}`}><span>{course.mark}</span><i /><b /></div>
                    <div className="course-body">
                      <span className="subject">{course.subject}</span>
                      <h3>{course.title}</h3>
                      <p>{course.lesson}</p>
                      <div className="progress-row"><div><span style={{ width: `${course.progress}%` }} /></div><strong>{course.progress}%</strong></div>
                      <span className="lesson-count">{course.meta}</span>
                    </div>
                  </article>
                ))}
              </div>
            </section>

            <aside className="right-rail reveal delay-3">
              <section className="tutor-card">
                <div className="tutor-orb"><Sparkles size={27} /></div>
                <span className="ai-label">AI STUDY PARTNER</span>
                <h2>Stuck on something?</h2>
                <p>Ask questions and get guidance grounded in your course material.</p>
                <button onClick={() => setTutorOpen(true)}>Ask your tutor <MessageCircleMore size={17} /></button>
              </section>

              <section className="achievement-card">
                <div className="achievement-icon"><Trophy size={21} /></div>
                <div><span>NEW ACHIEVEMENT</span><strong>Curious mind</strong><p>Asked 10 thoughtful questions</p></div>
              </section>
            </aside>
          </div>

          <section className="upcoming reveal delay-3">
            <div className="section-heading">
              <div><p className="eyebrow">PLAN AHEAD</p><h2>Coming up</h2></div>
              <button>Open calendar <ArrowRight size={15} /></button>
            </div>
            <div className="task-list">
              {tasks.map((task) => (
                <article className="task-row" key={task.title}>
                  <div className="task-date"><strong>{task.date}</strong><span>{task.month}</span></div>
                  <div className="task-copy"><strong>{task.title}</strong><span>{task.course}</span></div>
                  <span className="task-kind">{task.kind}</span>
                  <div className="task-time"><Clock3 size={15} /> Due in {task.time}</div>
                  <button aria-label={`Open ${task.title}`}><ChevronRight size={19} /></button>
                </article>
              ))}
            </div>
          </section>
        </div>
      </main>

      {tutorOpen && (
        <div className="tutor-panel" role="dialog" aria-modal="true" aria-label="AI study partner">
          <div className="tutor-panel-head">
            <div className="tutor-orb small"><Sparkles size={18} /></div>
            <div><strong>Study partner</strong><span>Grounded in your courses</span></div>
            <button onClick={() => setTutorOpen(false)} aria-label="Close tutor"><X size={19} /></button>
          </div>
          <div className="chat-area">
            <div className="chat-intro"><Target size={24} /><p>{tutorMessage}</p></div>
            <div className="suggestions">
              <button onClick={() => setQuestion("Can you explain kinetic energy?")}>Explain kinetic energy</button>
              <button onClick={() => setQuestion("Give me a real-world example")}>Give me an example</button>
            </div>
          </div>
          <div className="chat-input">
            <input
              value={question}
              onChange={(event) => setQuestion(event.target.value)}
              onKeyDown={(event) => event.key === "Enter" && askTutor()}
              placeholder="Ask about your lesson..."
              aria-label="Ask the study partner"
            />
            <button onClick={askTutor} aria-label="Send question"><Send size={18} /></button>
          </div>
          <p className="tutor-note">AI can make mistakes. Check important details with your teacher.</p>
        </div>
      )}
    </div>
  );
}

export default App;
