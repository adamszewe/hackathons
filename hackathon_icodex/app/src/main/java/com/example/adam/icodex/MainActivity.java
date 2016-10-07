package com.example.adam.icodex;

import android.content.Context;
import android.media.AudioAttributes;
import android.media.MediaPlayer;
import android.media.SoundPool;
import android.os.Handler;
import android.os.Message;
import android.provider.MediaStore;
import android.support.v4.content.ContextCompat;
import android.support.v4.view.MotionEventCompat;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.Menu;
import android.view.MenuInflater;
import android.view.MenuItem;
import android.view.MotionEvent;
import android.view.View;
import android.widget.LinearLayout;
import android.widget.TextView;

import java.io.IOException;
import java.util.HashMap;
import java.util.Map;
import java.util.Queue;
import java.util.concurrent.LinkedBlockingDeque;
import java.util.concurrent.LinkedBlockingQueue;

import butterknife.BindView;
import butterknife.ButterKnife;


public class MainActivity extends AppCompatActivity {

    private static final String TAG = MainActivity.class.getSimpleName();

    private static final String TEXT = "Nella lontana Russia, in una casetta sul limitar del bosco, viveva Pierino con il suo nonno. Pierino desiderava diventare cacciatore di lupi, ma il nonno gli diceva: -Sei troppo piccolo ora, devi avere pazienza.- Un pomeriggio, mentre il nonno riposava, Pierino s'incamminò nel bosco portando con sè una fune ed il suo piccolo fucile. Voleva catturare un lupo!  Sul sentiero incontrò Sascia il passerotto che volle accompagnarlo in quella pericolosa avventura. Si unirono a loro anche Sonia l'anatra ed Ivan il gatto.  La comitiva avanzava nella foresta, quando un'ombra nera si avventò su di loro. Era il lupo!  Pierino ed Ivan si arrampicarono su un albero. I lupo stava per raggiungerli, ma Pierino ebbe un'idea. Fece volare Sascia attorno al lupo per distrarlo e poi, lanciando la sua corda, gli legò la coda. Pierino ed Ivan tirarono tanto quella corda che il lupo ben presto restò appeso al ramo. Da lontano si udì il corno dei cacciatori. Allora Sascia volò a cercarli e, svolazzandogli intorno, li convinse a seguirlo.  Immaginate la loro faccia quando trovarono un gatto ed un bimbo a cavalcioni su un ramo e sotto, un lupo legato come una salsiccia.  Tornarono al villaggio tutti trionfanti.  Il nonno, che attendeva preoccupato, rimase sbigottito vedendo Pierino vittorioso. Camminava fiero davanti ai cacciatori ed il nonno fu costretto ad ammettere che il nipotino ora era grande abbastanza per essere chiamato cacciatore di lupi!";

    private Queue<String> textQueue = new LinkedBlockingDeque<>();

    private Map<View, Queue<View>> mMapRowToQueue = new HashMap<>();

    private Map<View, Integer> mMapViewToTrack = new HashMap<>();


    private Queue<Integer> mLoadedSounds = new LinkedBlockingQueue<>();

    private Map<Integer, Integer> mII = new HashMap<>();

    private Map<Integer, Long> mMapDurations = new HashMap<>();

    private Context mContext;

    private int mTrackIndex = 0;

    private boolean isPlaying = false;

    private Queue<Integer> mTracksQueue = new LinkedBlockingQueue<>();






    SoundPool mSoundPool = new SoundPool.Builder()
            .setMaxStreams(2)
            .setAudioAttributes(new AudioAttributes.Builder()
                    .setContentType(AudioAttributes.CONTENT_TYPE_SPEECH)
                    .setUsage(AudioAttributes.USAGE_GAME)
                    .build()
            )
            .build();


    Handler mTimeoutHandler;

    @BindView(R.id.main_layout_ll)
    LinearLayout mMainLayoutLl;



    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        // basic setup
        mContext = getApplicationContext();
        ButterKnife.bind(this);

        init();

    } // end of onCreate


    /**
     * init all the layout
     */
    public void init() {

        LayoutInflater inflater = this.getLayoutInflater();
        // get the text and divide it in parts
        String[] arr = TEXT.split(" ");
        LinearLayout row = new LinearLayout(mContext);
        int wordCounter = 0;

        // media player

        for (final String word : arr) {
            textQueue.add(word);

            if (wordCounter % 8 == 0) {
                row = (LinearLayout) inflater.inflate(R.layout.textrow, null);
                mMainLayoutLl.addView(row);
                Queue<View> mTextViewRow = new LinkedBlockingQueue<>();
                mMapRowToQueue.put((View) row, mTextViewRow);
            }

            TextView wordTextView = (TextView) inflater.inflate(R.layout.view_text, null);
            wordTextView.setText(word);

            if (wordCounter < 90) {
                // link the word with the audio
                mMapViewToTrack.put(wordTextView, wordCounter);

                mII.put(wordCounter, mSoundPool.load(this, Utils.sAudioArray[wordCounter], 1));
            }

            row.addView(wordTextView);
            ((Queue<View>) mMapRowToQueue.get(row)).add(wordTextView);

            wordCounter++;

            row.setOnTouchListener(new View.OnTouchListener() {
                @Override
                public boolean onTouch(View v, MotionEvent event) {
                    int action = MotionEventCompat.getActionMasked(event);

                    switch(action) {
                        case (MotionEvent.ACTION_DOWN) :
                            Log.d(TAG, "action down");
                            return true;
                        case (MotionEvent.ACTION_MOVE) :
                            float xpos = event.getRawX();
                            float ypos = event.getRawY();
                            onMove(xpos, ypos, v);
                            return true;
                        case (MotionEvent.ACTION_UP) :
                            return true;
                        case (MotionEvent.ACTION_CANCEL) :
                            return true;
                        case (MotionEvent.ACTION_OUTSIDE) :
                            return true;
                        default :
                            return false;
                    }
                }
            });
        }
    }





    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        MenuInflater inflater = getMenuInflater();
        inflater.inflate(R.menu.menu_clearall, menu);
        return true;
    }



    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        int id = item.getItemId();
        switch (id) {
            case R.id.clear_action:
                for (View v : mMapViewToTrack.keySet()) {
                    v.setBackgroundColor(ContextCompat.getColor(mContext, android.R.color.white));
                }
                Log.d(TAG, "cleared");
                break;
        }
        return super.onOptionsItemSelected(item);
    }



    void playQueue(final int index) {
        if (index > 85) return;     // we have only 90 tracks.... - it's a demo after all :)

        Log.d(TAG, "going to play: " + index + " isPlaying:" + isPlaying);

        if (isPlaying) {
            // todo add to the queue
            mTracksQueue.add(index);
            return;
        }

        mTimeoutHandler = new Handler() {

            public void handleMessage(Message msg) {
                if (msg.what == 0) {
                    // if there is a song in the queue the play it
                    Log.d(TAG, "finished playing track: " + index);
                    mSoundPool.stop(mII.get(index));
                    isPlaying = false;
                    mTimeoutHandler = null;
                    if (!mTracksQueue.isEmpty()) {
                        playQueue(mTracksQueue.poll());
                    }
                }
                super.handleMessage(msg);
            }
        };

        long duration = Utils.durations[index] - 60;
        mTimeoutHandler.sendEmptyMessageDelayed(0, duration);
        mSoundPool.play(
                mII.get(index),
                1,
                1,
                0,
                0,
                1
        );
        isPlaying = true;
    }




    public void onMove(float x, float y, View v) {
        // get the queue of TextViews on the LinearLayout row
        if (mMapRowToQueue.containsKey(v)) {

            final Queue<View> vq = mMapRowToQueue.get(v);
            final View view = positionToView(x, y, vq);

            // if the returned view is not null, which means it belongs to the current row
            // and the view is next in the queue, then play it
            if (view != null && view.equals(vq.peek())) {
                final View nextView = vq.poll();
                int index = mMapViewToTrack.get(nextView);
                view.setBackgroundColor(ContextCompat.getColor(view.getContext(), android.R.color.holo_green_light));
                playQueue(index);
            }
        }
    }







    /**
     * Given a point on the row of text get the textview if the user is touching it
     */
    private View positionToView(float x, float y, Queue<View> viewQueue) {
        View v = null;
        for (View wordView : viewQueue) {
            int xy[] = new int[2];
            wordView.getLocationInWindow(xy);
            int viewBegin = xy[0];
            int viewEnd = viewBegin + wordView.getWidth();
            if ((viewBegin <= x) && (x <= viewEnd)) {
                v = wordView;
                break;
            }
        }
        return v;
    }




}
