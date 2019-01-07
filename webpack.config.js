const path = require('path');

module.exports = {
    mode: 'development',
    entry: {
        bundle: [
            './src/js/display_lyrics.js',
            './src/scss/index.scss',
            './src/scss/login_check.scss',
            './src/scss/logout.scss',
            './src/scss/lyrics_list.scss',
            './src/scss/register_lyrics.scss',
            './src/scss/register_lyrics_accept.scss',
            './src/scss/add_new_user_check.scss',
            './src/scss/add_new_user_done.scss',
        ]
    },
    output: {
        path: path.join(__dirname, 'dist'),
        filename: '[name].js',
    },
    resolve: {
        // モジュールを読み込むときに検索するディレクトリの設定
        modules: [
            path.join(__dirname, 'src/js'),
            path.join(__dirname, 'src/scss'),
            path.join(__dirname, 'node_modules')
        ],
        // importするときに省略できる拡張子の設定
        extensions: ['.js', '.scss'],
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                loader: 'babel-loader',
                query: {
                    presets: ['@babel/preset-env']
                },
            },
            {
                test: /\.scss$/,
                use: [
                    {
                        loader: 'css-loader',
                        options: {
                            url: false,
                            minimize: true,
                        }
                    },
                    {
                        loader: 'postcss-loader',
                        options: {
                            plugins: [
                                require('autoprefixer')({
                                    'browsers': [
                                        '> 1%',
                                        'IE 10'
                                    ]
                                })
                            ]
                        },
                    },
                    'sass-loader',
                ]
            },
        ],
    },
};